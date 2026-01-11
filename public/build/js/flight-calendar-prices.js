/**
 * Flight Calendar Prices Module
 * Handles fetching cheapest dates and price verification
 */

class FlightCalendarPrices {
    constructor(config = {}) {
        this.config = {
            cheapestDatesUrl: '/api/flights/cheapest-dates',
            calendarUrl: '/api/flight-calendar',
            verifyPriceUrl: '/api/flights/verify-price',
            ...config
        };

        this.currentPrices = {};
        this.isLoading = false;
        this.init();
    }

    init() {
        // Watch for date picker open events
        $(document).on('dp.show', '.datetimepicker', (e) => {
            this.handleDatePickerOpen(e);
        });
    }

    /**
     * When date picker opens, fetch prices for the displayed month
     */
    handleDatePickerOpen(event) {
        const $picker = $(event.target);
        const pickerInstance = $picker.data('DateTimePicker');
        
        if (!pickerInstance) return;

        // Get the currently viewed month in the picker
        const viewDate = pickerInstance.viewDate();
        const month = viewDate.format('YYYY-MM');

        // Get search parameters from the form
        const params = this.getSearchParams($picker);
        
        if (!params.origin || !params.destination) {
            console.warn('Missing origin or destination for cheapest dates lookup');
            return;
        }

        // Fetch prices for this month
        this.fetchCheapestPrices({
            ...params,
            month: month
        }, $picker);
    }

    /**
     * Fetch cheapest prices for a specific month
     */
    fetchCheapestPrices(params, $picker) {
        if (this.isLoading) return;

        this.isLoading = true;
        
        // Show loading indicator
        this.showPriceLoading($picker);

        // Prefer Duffel for calendar prices (Amadeus has API issues)
        const urlToCall = this.config.cheapestDatesUrl || this.config.calendarUrl;

        $.ajax({
            url: urlToCall,
            type: 'GET',
            data: params,
            dataType: 'json',
            success: (response) => {
                if (response && response.success && response.prices) {
                    this.currentPrices = response.prices;
                    this.populatePricesInCalendar(response.prices, $picker);
                } else if (response && response.prices) {
                    // tolerate non-standard success flag
                    this.currentPrices = response.prices;
                    this.populatePricesInCalendar(response.prices, $picker);
                }
            },
            error: (xhr) => {
                console.error('Failed to fetch calendar prices:', xhr);
                this.hidePriceLoading($picker);
            },
            complete: () => {
                this.isLoading = false;
                this.hidePriceLoading($picker);
            }
        });
    }

    /**
     * Populate prices in the calendar widget
     */
    populatePricesInCalendar(prices, $picker) {
        // Wait a bit for the calendar to be fully rendered
        setTimeout(() => {
            // Try multiple selectors for the calendar widget
            let $calendar = $picker.closest('.datetimepicker').find('.datetimepicker-calendar, .datepicker');

            if ($calendar.length === 0) {
                // Try alternative selectors
                $calendar = $('.datetimepicker-widget, .bootstrap-datetimepicker-widget').filter(':visible');
            }

            if ($calendar.length === 0) {
                // Try even more specific selectors
                $calendar = $('.bootstrap-datetimepicker-widget:visible, .datetimepicker-dropdown:visible');
            }

            if ($calendar.length > 0) {
                this.addPricesToDays(prices, $calendar);
            } else {
                console.warn('Calendar widget not found, trying document body');
                // As a last resort, try the document body (though this is less efficient)
                this.addPricesToDays(prices, $('body'));
            }
        }, 200); // Increased timeout
    }

    /**
     * Add price labels to each day in the calendar
     */
    addPricesToDays(prices, $container) {
        const self = this;
        console.log('addPricesToDays called with container:', $container.length, 'elements');
        console.log('Prices data:', JSON.stringify(prices).substring(0, 100) + '...');

        // Try different selectors for calendar days
        const daySelectors = [
            'span.day',
            'td.day',
            'a.day',
            '.day',
            '[data-day]',
            '.calendar-day',
            '.picker-day'
        ];

        let $days = $();
        for (const selector of daySelectors) {
            const $found = $container.find(selector);
            if ($found.length > 0) {
                $days = $found;
                console.log('Found days using selector:', selector, 'count:', $found.length);
                break;
            }
        }

        if ($days.length === 0) {
            console.warn('No day elements found in calendar widget — attempting numeric-text fallback');

            // Fallback: find elements whose inner text is a 1- or 2-digit day number
            const $numericDays = $container.find('td, a, span, div, button').filter(function() {
                const txt = $(this).text().trim();
                return /^\d{1,2}$/.test(txt);
            }).filter(function() {
                // also ensure the element is visible and not part of a header or disabled cell
                return $(this).is(':visible') && !$(this).closest('.disabled, .old, .new').length;
            });

            if ($numericDays.length > 0) {
                $days = $numericDays;
                console.log('Found days by numeric text, count:', $days.length);
            } else {
                console.warn('No numeric-day elements found either — aborting price annotation');
                return;
            }
        }

        // Iterate through prices object to find and annotate matching day elements
        for (const dateStr in prices) {
            const priceData = prices[dateStr];
            const dayNum = parseInt(priceData.day);

            if (!isNaN(dayNum) && dayNum > 0 && dayNum <= 31 && priceData.price) {
                // Find the day element for this day number
                const $dayElement = $days.filter(function() {
                    const txt = $(this).text().trim();
                    const num = parseInt(txt);
                    return num === dayNum;
                });

                if ($dayElement.length > 0) {
                    const price = priceData.price;
                    const currency = priceData.currency || 'USD';

                    console.log('Adding price for day', dayNum, 'date:', dateStr, 'price:', price);

                    // Create price element
                    const $priceLabel = $('<div>')
                        .addClass('day-price')
                        .css({
                            'font-size': '10px',
                            'color': '#0066cc',
                            'font-weight': 'bold',
                            'margin-top': '2px',
                            'display': 'block'
                        })
                        .text('$' + self.formatPrice(price));

                    // Clear any existing price label
                    $dayElement.find('.day-price').remove();
                    $dayElement.append($priceLabel);

                    // Add click handler to verify price when date is selected
                    $dayElement.on('click', () => {
                        self.verifyAndSelectDate(dateStr, $dayElement);
                    });
                }
            }
        }
    }

    /**
     * Find the date string for a given day number in the current month
     */
    findDateForDay(dayNum, prices) {
        for (const dateStr in prices) {
            const day = parseInt(prices[dateStr].day);
            if (day === dayNum) {
                return dateStr;
            }
        }
        return null;
    }

    /**
     * Verify price when user clicks on a specific date
     */
    verifyAndSelectDate(dateStr, $dayElement) {
        const params = this.getSearchParamsForDate(dateStr);
        
        if (!params.origin || !params.destination) {
            console.warn('Missing origin or destination');
            return;
        }

        // Show loading state
        $dayElement.css('opacity', '0.6');

        $.ajax({
            url: this.config.verifyPriceUrl,
            type: 'POST',
            data: {
                ...params,
                departure_date: dateStr,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: (response) => {
                if (response.success) {
                    // Price verified! Update UI and show confirmation
                    this.showPriceVerified(dateStr, response.price);
                    
                    // Trigger date selection in picker
                    this.selectDateInPicker(dateStr);
                } else {
                    console.error('Price verification failed:', response.error);
                    alert('Unable to verify price: ' + (response.error || 'Unknown error'));
                }
            },
            error: (xhr) => {
                console.error('Price verification error:', xhr);
                alert('Error verifying flight price');
            },
            complete: () => {
                $dayElement.css('opacity', '1');
            }
        });
    }

    /**
     * Show confirmation when price is verified
     */
    showPriceVerified(dateStr, priceData) {
        // Optional: Show a toast or notification
        const message = `Price verified: $${this.formatPrice(priceData.amount)} ${priceData.currency}`;
        
        if (window.toastr) {
            toastr.success(message, 'Price Confirmed');
        } else {
            console.log('✓ ' + message);
            alert(message);
        }
    }

    /**
     * Trigger date selection in the picker
     */
    selectDateInPicker(dateStr) {
        const date = moment(dateStr, 'YYYY-MM-DD');
        
        // Find the active date picker and set its value
        const $picker = $('.datetimepicker:visible');
        if ($picker.length > 0) {
            const pickerInstance = $picker.data('DateTimePicker');
            if (pickerInstance) {
                pickerInstance.date(date);
            }
        }
    }

    /**
     * Get search parameters from the form
     */
    getSearchParams($picker) {
        const $form = $picker.closest('form');
        
        return {
            origin: $form.find('[name="origin"], .origin-value, input[data-origin]').val(),
            destination: $form.find('[name="destination"], .destination-value, input[data-destination]').val(),
            passengers: $form.find('[name="passengers"], .adults-count').val() || '1',
            cabin_class: $form.find('[name="cabin_class"]').val() || 'economy'
        };
    }

    /**
     * Get search parameters with origin/destination for verification
     */
    getSearchParamsForDate(dateStr) {
        // Try multiple ways to find the form and its values
        let $form = $('form[action*="flights.search"]');
        
        // If not found, try to find form by ID or other selectors
        if ($form.length === 0) {
            $form = $('#flight-search-form');
        }
        
        // If still not found, find the closest form from any visible element
        if ($form.length === 0) {
            $form = $('form').first();
        }

        // Extract origin and destination from hidden inputs
        let origin = $form.find('input[name="origin"], .origin-value').val();
        let destination = $form.find('input[name="destination"], .destination-value').val();
        
        console.log('getSearchParamsForDate - origin:', origin, 'destination:', destination, 'form found:', $form.length > 0);
        
        return {
            origin: origin,
            destination: destination,
            passengers: $form.find('[name="passengers"], .adults-count').val() || '1',
            cabin_class: $form.find('[name="cabin_class"]').val() || 'economy',
            return_date: $form.find('[name="return_date"], .return-date').val() || null
        };
    }

    /**
     * Show loading indicator
     */
    showPriceLoading($picker) {
        const $widget = $picker.closest('.datetimepicker').find('.datetimepicker-widget, .bootstrap-datetimepicker-widget');
        if ($widget.find('.price-loading').length === 0) {
            $widget.prepend(
                $('<div>')
                    .addClass('price-loading')
                    .css({
                        'text-align': 'center',
                        'padding': '10px',
                        'border-bottom': '1px solid #ddd',
                        'font-size': '12px',
                        'color': '#666'
                    })
                    .html('<i class="fa fa-spinner fa-spin"></i> Loading prices...')
            );
        }
    }

    /**
     * Hide loading indicator
     */
    hidePriceLoading($picker) {
        const $widget = $picker.closest('.datetimepicker').find('.datetimepicker-widget, .bootstrap-datetimepicker-widget');
        $widget.find('.price-loading').remove();
    }

    /**
     * Format price with thousand separators
     */
    formatPrice(price) {
        return parseFloat(price).toFixed(2);
    }
}

// Initialize when document is ready and jQuery is available
function initFlightCalendarPrices() {
    if (typeof jQuery !== 'undefined' && typeof $ !== 'undefined') {
        $(document).ready(function() {
            // Only initialize if we have date pickers on the page
            if ($('.datetimepicker').length > 0) {
                if (!window.flightCalendarPrices) {
                    // Use server-injected config if available (set in Blade before this script)
                    const injectedConfig = (typeof window.flightCalendarConfig !== 'undefined') ? window.flightCalendarConfig : {};
                    window.flightCalendarPrices = new FlightCalendarPrices(injectedConfig);
                    console.log('Flight calendar prices initialized');
                }
            }
        });
    } else {
        // jQuery not loaded yet, try again in a moment
        setTimeout(initFlightCalendarPrices, 100);
    }
}

// Start initialization
initFlightCalendarPrices();

/**
 * Flight Search Form JavaScript
 * Handles airport selection, traveler updates, and form submission
 */

document.addEventListener('DOMContentLoaded', function() {
    const flightForm = document.getElementById('flight-search-form');
    
    // Handle trip type changes
    const tripTypeRadios = document.querySelectorAll('.trip-type-radio');
    tripTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('trip-type').value = this.value;
            updateVisibility();
        });
    });

    // Handle origin airport selection
    const originSearch = document.querySelector('.origin-search');
    const originList = document.querySelector('.origin-list');
    const originInput = document.querySelector('.origin-value');
    const originDisplay = document.querySelector('input[name="origin_display"]');
    const originAirport = document.querySelector('.origin-airport');

    if (originSearch) {
        originSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length > 0) {
                // Filter existing airport list
                const items = originList.querySelectorAll('li');
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(query) ? 'block' : 'none';
                });
                
                // Also fetch from API if needed
                if (query.length >= 2) {
                    fetchAirports(query, originList, 'origin');
                }
            } else {
                const items = originList.querySelectorAll('li');
                items.forEach(item => item.style.display = 'block');
            }
        });
    }

    // Handle origin airport option selection
    document.addEventListener('click', function(e) {
        if (e.target.closest('.origin-list .airport-option')) {
            e.preventDefault();
            const iata = e.target.closest('[data-iata]').dataset.iata;
            const city = e.target.closest('[data-iata]').dataset.city;
            const country = e.target.closest('[data-iata]').dataset.country;
            
            originInput.value = iata;
            originDisplay.value = city + ' (' + iata + ')';
            originAirport.textContent = country;
        }
    });

    // Handle destination airport selection
    const destinationSearch = document.querySelector('.destination-search');
    const destinationList = document.querySelector('.destination-list');
    const destinationInput = document.querySelector('.destination-value');
    const destinationDisplay = document.querySelector('input[name="destination_display"]');
    const destinationAirport = document.querySelector('.destination-airport');

    if (destinationSearch) {
        destinationSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length > 0) {
                const items = destinationList.querySelectorAll('li');
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(query) ? 'block' : 'none';
                });
                
                if (query.length >= 2) {
                    fetchAirports(query, destinationList, 'destination');
                }
            } else {
                const items = destinationList.querySelectorAll('li');
                items.forEach(item => item.style.display = 'block');
            }
        });
    }

    document.addEventListener('click', function(e) {
        if (e.target.closest('.destination-list .airport-option')) {
            e.preventDefault();
            const iata = e.target.closest('[data-iata]').dataset.iata;
            const city = e.target.closest('[data-iata]').dataset.city;
            const country = e.target.closest('[data-iata]').dataset.country;
            
            destinationInput.value = iata;
            destinationDisplay.value = city + ' (' + iata + ')';
            destinationAirport.textContent = country;
        }
    });

    // Handle travelers count
    const adultsInput = document.querySelector('.adults-count');
    const childrenInput = document.querySelector('.children-count');
    const infantsInput = document.querySelector('.infants-count');

    const updatePassengersCount = () => {
        const adults = parseInt(adultsInput.value || 0);
        const children = parseInt(childrenInput.value || 0);
        const infants = parseInt(infantsInput.value || 0);
        const total = adults + children + infants;
        
        document.getElementById('passengers').value = total || 1;
        document.querySelector('.total-persons').textContent = total || 1;
        
        let summary = '';
        if (adults > 0) summary += adults + ' Adult' + (adults > 1 ? 's' : '');
        if (children > 0) summary += (summary ? ', ' : '') + children + ' Child' + (children > 1 ? 'ren' : '');
        if (infants > 0) summary += (summary ? ', ' : '') + infants + ' Infant' + (infants > 1 ? 's' : '');
        
        document.querySelector('.traveller-summary').textContent = summary || '1 Adult';
    };

    // Quantity buttons
    document.querySelectorAll('.quantity-left-minus, .quantity-right-plus').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const field = this.dataset.field;
            const input = document.querySelector('.' + field + '-count');
            let value = parseInt(input.value || 0);
            
            if (this.classList.contains('quantity-left-minus')) {
                value = Math.max(0, value - 1);
            } else {
                value = Math.min(9, value + 1);
            }
            
            input.value = value;
            updatePassengersCount();
        });
    });

    // Handle cabin class selection
    document.querySelectorAll('.cabin-class-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('cabin_class').value = this.value;
            document.querySelector('.cabin-summary').textContent = this.value.replace('_', ' ');
        });
    });

    // Apply travelers button
    const applyButton = document.querySelector('.apply-travelers');
    if (applyButton) {
        applyButton.addEventListener('click', function(e) {
            e.preventDefault();
            updatePassengersCount();
            // Close dropdown (Bootstrap)
            const dropdown = this.closest('.dropdown-menu');
            if (dropdown) {
                const toggle = dropdown.previousElementSibling;
                const bsDropdown = bootstrap.Dropdown.getInstance(toggle) || new bootstrap.Dropdown(toggle);
                bsDropdown.hide();
            }
        });
    }

    // Initialize dates
    initializeDatePickers();

    // Form submission
    if (flightForm) {
        flightForm.addEventListener('submit', function(e) {
            e.preventDefault();
            validateAndSubmit(this);
        });
    }

    function initializeDatePickers() {
        const departureInput = document.querySelector('.departure-date');
        const returnInput = document.querySelector('.return-date');

        if (departureInput) {
            departureInput.addEventListener('change', function() {
                const date = new Date(this.value);
                const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                document.querySelector('.departure-day').textContent = days[date.getDay()];
            });
        }

        if (returnInput) {
            returnInput.addEventListener('change', function() {
                const date = new Date(this.value);
                const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                document.querySelector('.return-day').textContent = days[date.getDay()];
            });
        }
    }

    function validateAndSubmit(form) {
        const origin = document.querySelector('.origin-value').value;
        const destination = document.querySelector('.destination-value').value;
        const departureDate = document.querySelector('.departure-date').value;

        if (!origin || !destination || !departureDate) {
            alert('Please fill in all required fields: origin, destination, and departure date.');
            return false;
        }

        // Dates from datetimepicker are already in YYYY-MM-DD format
        // No need to convert - just ensure they stay in this format
        const depDateInput = document.querySelector('.departure-date');
        if (depDateInput.value && !depDateInput.value.match(/^\d{4}-\d{2}-\d{2}$/)) {
            // Only convert if not already in YYYY-MM-DD format
            const depDateObj = new Date(depDateInput.value);
            depDateInput.value = depDateObj.toISOString().split('T')[0];
        }

        const returnDateInput = document.querySelector('.return-date');
        if (returnDateInput && returnDateInput.value) {
            if (!returnDateInput.value.match(/^\d{4}-\d{2}-\d{2}$/)) {
                // Only convert if not already in YYYY-MM-DD format
                const retDateObj = new Date(returnDateInput.value);
                returnDateInput.value = retDateObj.toISOString().split('T')[0];
            }
        }

        form.submit();
    }

    function fetchAirports(query, listElement, type) {
        fetch(`/api/airports/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    // Update the list with API results
                    const parentList = listElement;
                    // Clear existing items (keep only the ones from this search)
                    const existingItems = parentList.querySelectorAll('li');
                    existingItems.forEach(item => {
                        // Only show items that match the search
                        const text = item.textContent.toLowerCase();
                        item.style.display = text.includes(query) ? 'block' : 'none';
                    });
                }
            })
            .catch(error => console.error('Error fetching airports:', error));
    }

    function updateVisibility() {
        const tripType = document.getElementById('trip-type').value;
        const normalTrip = document.querySelector('.normal-trip');
        const multiTrip = document.querySelector('.multi-trip');

        if (tripType === 'multiway') {
            normalTrip.style.display = 'none';
            if (multiTrip) multiTrip.style.display = 'block';
        } else {
            normalTrip.style.display = 'block';
            if (multiTrip) multiTrip.style.display = 'none';

            // Update return date visibility based on trip type
            const returnField = document.querySelector('.form-item.round-drip');
            if (returnField) {
                returnField.style.display = tripType === 'roundtrip' ? 'block' : 'none';
            }
        }
    }

    // Initialize visibility on page load
    updateVisibility();
});

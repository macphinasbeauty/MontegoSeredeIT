

<script>
$(document).ready(function() {
    // Tour Destination Auto-suggest
    $(document).on('input', '.tour-destination-search', function() {
        const searchTerm = $(this).val().trim();
        const $dropdown = $(this).closest('.dropdown');
        const $dropdownMenu = $dropdown.find('.dropdown-menu');

        if (searchTerm.length < 2) {
            $('.tour-destination-list').empty();
            $dropdownMenu.removeClass('show');
            return;
        }

        // Show dropdown manually
        $dropdownMenu.addClass('show');

        // Call tour autosuggest API with cache busting
        fetch(`{{ url('/api/tours/destinations/autosuggest') }}?term=${encodeURIComponent(searchTerm)}&_=${Date.now()}`)
            .then(response => {
                console.log('API Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('API Response data:', data);
                $('.tour-destination-list').empty();

                if (data && data.length > 0) {
                    data.forEach(destination => {
                        const destinationHtml = `
                            <li class="border-bottom">
                                <a class="dropdown-item tour-destination-option" href="#"
                                   data-name="${destination.name}"
                                   data-country="${destination.country}"
                                   data-value="${destination.value}">
                                    <h6 class="fs-16 fw-medium">${destination.display}</h6>
                                    ${destination.country ? `<p class="mb-0">${destination.country}</p>` : ''}
                                </a>
                            </li>
                        `;
                        $('.tour-destination-list').append(destinationHtml);
                    });
                } else {
                    $('.tour-destination-list').append(`
                        <li class="text-center py-3 text-muted">
                            <small>No destinations found</small>
                        </li>
                    `);
                }
            })
            .catch(error => {
                console.error('Tour destination search error:', error);
                $('.tour-destination-list').empty().append(`
                    <li class="text-center py-3 text-muted">
                        <small>Error searching destinations</small>
                    </li>
                `);
            });
    });

    // Handle tour destination selection
    $(document).on('click', '.tour-destination-option', function(e) {
        e.preventDefault();
        const name = $(this).data('name');
        const country = $(this).data('country');
        const value = $(this).data('value');

        const displayValue = country ? `${name}, ${country}` : name;
        $('.tour-destination-search').val(displayValue);
        $('.tour-destination-info').text(displayValue);

        // Close dropdown
        $('.dropdown-menu').removeClass('show');
    });

    // Hide dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });

    // Hide dropdown when input loses focus (with delay to allow clicks)
    $(document).on('blur', '.tour-destination-search', function() {
        setTimeout(function() {
            $('.dropdown-menu').removeClass('show');
        }, 150);
    });

    // Handle travelers selection (for tour-grid form with individual counts)
    $(document).on('click', '.quantity-left-minus', function(e) {
        e.preventDefault();
        var field = $(this).attr('data-field');
        if (field && field.startsWith('tour_')) {
            var input = $(this).closest('.custom-increment').find('input[name="' + field + '"]');
            var currentVal = parseInt(input.val());
            var minVal = parseInt(input.attr('min')) || 0;

            if (currentVal > minVal) {
                input.val(currentVal - 1);
                input.trigger('change');
            }
        }
    });

    $(document).on('click', '.quantity-right-plus', function(e) {
        e.preventDefault();
        var field = $(this).attr('data-field');
        if (field && field.startsWith('tour_')) {
            var input = $(this).closest('.custom-increment').find('input[name="' + field + '"]');
            var currentVal = parseInt(input.val());
            var maxVal = parseInt(input.attr('max')) || 9;

            if (currentVal < maxVal) {
                input.val(currentVal + 1);
                input.trigger('change');
            }
        }
    });

    // Update tour traveller summary when values change
    $(document).on('change', '.tour-adults-count, .tour-children-count, .tour-infants-count', function() {
        updateTourTravellerDisplay();
    });

    function updateTourTravellerDisplay() {
        let adults = parseInt($('.tour-adults-count').val()) || 2;
        let children = parseInt($('.tour-children-count').val()) || 0;
        let infants = parseInt($('.tour-infants-count').val()) || 0;

        // Validate minimum values
        if (adults < 1) adults = 1;
        if (children < 0) children = 0;
        if (infants < 0) infants = 0;

        const totalPersons = adults + children + infants;

        // Build summary text
        let summary = '';
        if (adults > 0) {
            summary += adults + (adults === 1 ? ' Adult' : ' Adults') + ' ( 12+ Yrs )';
        }
        if (children > 0) {
            if (summary) summary += ', ';
            summary += children + (children === 1 ? ' Child' : ' Children') + ' ( 2-12 Yrs )';
        }
        if (infants > 0) {
            if (summary) summary += ', ';
            summary += infants + (infants === 1 ? ' Infant' : ' Infants') + ' ( 0-2 Yrs )';
        }

        // Update display
        $('.dropdown .h5').html(totalPersons + ' <span class="fw-normal fs-14">Persons</span>');
        $('.dropdown .fs-12').html(summary || '2 Adults ( 12+ Yrs )');
        $('input[name="travelers"]').val(totalPersons);
    }

    $(document).on('click', '.tour-travellers-apply', function(e) {
        e.preventDefault();
        updateTourTravellerDisplay();
        // Close dropdown
        $(this).closest('.dropdown-menu').removeClass('show');
    });

    $(document).on('click', '.tour-travellers-cancel', function(e) {
        e.preventDefault();
        // Close dropdown without resetting values
        $(this).closest('.dropdown-menu').removeClass('show');
    });

    // Initialize tour traveller display on page load
    updateTourTravellerDisplay();

    // Initialize datepickers with existing values preserved
    $('.datetimepicker').each(function() {
        var existingValue = $(this).val();
        $(this).datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
            defaultViewDate: existingValue ? new Date(existingValue.split('-').reverse().join('-')) : new Date()
        });

        // If there's an existing value, set it properly
        if (existingValue) {
            $(this).datepicker('setDate', new Date(existingValue.split('-').reverse().join('-')));
        }
    });
});
</script>

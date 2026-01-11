// Flight List Search Form - Editable Search Parameters
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('flight-search-form');
    if (!form) return;

    // Trip Type Radio Buttons
    const tripTypeRadios = document.querySelectorAll('.trip-type-radio');
    tripTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('trip-type').value = this.value;
            const returnTrip = document.querySelector('.return-trip');
            if (this.value === 'roundtrip') {
                returnTrip.style.display = 'block';
            } else {
                returnTrip.style.display = 'none';
            }
        });
    });

    // Airport Selection - Origin
    const originSearch = document.querySelector('.origin-search');
    const originList = document.querySelector('.origin-list');
    const originValue = document.querySelector('.origin-value');
    const originDisplay = document.querySelector('input[name="origin_display"]');
    const originAirport = document.querySelector('.origin-airport');

    if (originSearch) {
        originSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const items = originList.querySelectorAll('a');
            items.forEach(item => {
                const city = item.dataset.city.toLowerCase();
                const iata = item.dataset.iata.toLowerCase();
                if (city.includes(query) || iata.includes(query)) {
                    item.parentElement.style.display = '';
                } else {
                    item.parentElement.style.display = 'none';
                }
            });
        });
    }

    // Airport Option Selection
    const airportOptions = document.querySelectorAll('.airport-option');
    airportOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const iata = this.dataset.iata;
            const city = this.dataset.city;
            const country = this.dataset.country;

            // Determine if this is origin or destination
            if (this.closest('.origin-list')) {
                // Origin
                originValue.value = iata;
                originDisplay.value = city;
                originAirport.textContent = iata;
                // Close dropdown
                const dropdown = this.closest('.dropdown-menu');
                const toggleBtn = dropdown.previousElementSibling;
                bootstrap.Dropdown.getInstance(toggleBtn)?.hide();
            } else if (this.closest('.destination-list')) {
                // Destination
                const destValue = document.querySelector('.destination-value');
                const destDisplay = document.querySelector('input[name="destination_display"]');
                const destAirport = document.querySelector('.destination-airport');
                
                destValue.value = iata;
                destDisplay.value = city;
                destAirport.textContent = iata;
                // Close dropdown
                const dropdown = this.closest('.dropdown-menu');
                const toggleBtn = dropdown.previousElementSibling;
                bootstrap.Dropdown.getInstance(toggleBtn)?.hide();
            }
        });
    });

    // Destination Search
    const destSearch = document.querySelector('.destination-search');
    const destList = document.querySelector('.destination-list');

    if (destSearch) {
        destSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const items = destList.querySelectorAll('a');
            items.forEach(item => {
                const city = item.dataset.city.toLowerCase();
                const iata = item.dataset.iata.toLowerCase();
                if (city.includes(query) || iata.includes(query)) {
                    item.parentElement.style.display = '';
                } else {
                    item.parentElement.style.display = 'none';
                }
            });
        });
    }

    // Date picker handling is now done in the main date picker initialization script
    // This prevents conflicts and ensures proper date formatting

    // Traveler Counter Buttons
    const quantityButtons = document.querySelectorAll('.btn-number');
    quantityButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const type = this.dataset.type;
            const field = this.dataset.field;
            const inputGroup = this.closest('.input-group');
            const input = inputGroup.querySelector('input[name="' + field + '"]');
            
            let currentValue = parseInt(input.value) || 0;
            
            if (type === 'plus') {
                currentValue++;
            } else if (type === 'minus' && currentValue > 0) {
                currentValue--;
            }
            
            input.value = currentValue;
            updateTravelerSummary();
        });
    });

    // Cabin Class Radio
    const cabinRadios = document.querySelectorAll('.cabin-class-radio');
    cabinRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateTravelerSummary();
        });
    });

    // Update Traveler Summary
    function updateTravelerSummary() {
        const adults = parseInt(document.querySelector('.adults-count')?.value || 1);
        const children = parseInt(document.querySelector('.children-count')?.value || 0);
        const infants = parseInt(document.querySelector('.infants-count')?.value || 0);
        const totalPassengers = adults + children + infants;

        const cabinClass = document.querySelector('input[name="cabin_class"]:checked')?.value || 'economy';
        const cabinDisplay = cabinClass.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());

        // Build summary text
        let summary = '';
        if (adults > 0) {
            summary += adults + (adults === 1 ? ' Adult' : ' Adults');
        }
        if (children > 0) {
            if (summary) summary += ', ';
            summary += children + (children === 1 ? ' Child' : ' Children');
        }
        if (infants > 0) {
            if (summary) summary += ', ';
            summary += infants + (infants === 1 ? ' Infant' : ' Infants');
        }
        if (!summary) summary = '1 Adult';

        // Update hidden field
        const passengersInput = document.querySelector('input[name="passengers"]');
        if (passengersInput) passengersInput.value = totalPassengers;

        // Update display
        const totalEl = document.querySelector('.total-persons');
        const summaryEl = document.querySelector('.traveller-summary');
        const cabinEl = document.querySelector('.cabin-summary');

        if (totalEl) totalEl.textContent = totalPassengers;
        if (summaryEl) summaryEl.textContent = summary;
        if (cabinEl) cabinEl.textContent = cabinDisplay;
    }

    // Initialize traveler summary on page load
    updateTravelerSummary();

    // Form Submission
    form.addEventListener('submit', function(e) {
        // Validate required fields
        const origin = document.querySelector('.origin-value').value;
        const destination = document.querySelector('.destination-value').value;
        const departureDate = document.querySelector('input[name="departure_date"]').value;

        if (!origin || !destination || !departureDate) {
            e.preventDefault();
            alert('Please fill in all required fields');
            return false;
        }

        // If roundtrip, check return date
        const tripType = document.getElementById('trip-type').value;
        if (tripType === 'roundtrip') {
            const returnDate = document.querySelector('input[name="return_date"]').value;
            if (!returnDate) {
                e.preventDefault();
                alert('Please select a return date for roundtrip flights');
                return false;
            }
        }
    });
});

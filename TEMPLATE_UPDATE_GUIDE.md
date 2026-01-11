# Template Update Implementation Guide

This guide provides specific instructions for updating each booking template to work with the new controllers.

## General Pattern for All Templates

### Grid/List Views
```blade
@forelse($hotels as $hotel)  {{-- or $cruises, $tours, $buses --}}
    <div class="item">
        <a href="{{ route('hotel-details', $hotel->id) }}">
            <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}">
        </a>
        <h5>{{ $hotel->name }}</h5>
        <p>{{ $hotel->description }}</p>
        <p>${{ $hotel->price }}</p>
    </div>
@empty
    <p>No items found</p>
@endforelse
```

### Details View
```blade
<h2>{{ $hotel->name }}</h2>
<p>{{ $hotel->description }}</p>
<img src="{{ $hotel->image }}" alt="{{ $hotel->name }}">
<a href="{{ route('hotel-booking', $hotel->id) }}" class="btn btn-primary">Book Now</a>
```

### Booking Form
```blade
<form action="{{ route('hotel-booking.store') }}" method="POST">
    @csrf
    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
    <input type="text" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <button type="submit">Confirm Booking</button>
</form>
```

---

## 1. Hotel Templates

### hotel-grid.blade.php
**Location**: `resources/views/hotel-grid.blade.php`

**Changes Required**:
1. Find the hardcoded hotel items (around line 1000+)
2. Replace with loop:
```blade
@forelse($hotels as $hotel)
    <div class="col-xl-4 col-md-6 d-flex">
        <div class="place-item mb-4 flex-fill">
            <div class="place-img">
                <div class="img-slider image-slide owl-carousel nav-center">
                    <div class="slide-images">
                        <a href="{{ route('hotel-details', $hotel->id) }}">
                            <img src="{{ $hotel->image }}" class="img-fluid" alt="{{ $hotel->name }}">
                        </a>
                    </div>
                </div>
                <div class="fav-item">
                    <a href="#" class="fav-icon"><i class="isax isax-heart5"></i></a>
                </div>
            </div>
            <div class="place-content">
                <h5 class="mb-1 text-truncate">
                    <a href="{{ route('hotel-details', $hotel->id) }}">{{ $hotel->name }}</a>
                </h5>
                <p class="d-flex align-items-center mb-2">
                    <i class="isax isax-location5 me-2"></i>{{ $hotel->location }}
                </p>
                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                    <h5 class="text-primary text-nowrap me-2">${{ $hotel->price }} 
                        <span class="fs-14 fw-normal text-default">/ Night</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <p class="text-center">No hotels found for your search</p>
    </div>
@endforelse
```

### hotel-list.blade.php
**Location**: `resources/views/hotel-list.blade.php`

**Changes Required**:
1. Find the hotel list items
2. Replace with loop similar to hotel-grid but in list format
3. Add links: `route('hotel-details', $hotel->id)` and `route('hotel-grid')` / `route('hotel-map')`

### hotel-map.blade.php
**Location**: `resources/views/hotel-map.blade.php`

**Changes Required**:
1. Initialize map with hotel locations
2. Add markers for each hotel:
```blade
@foreach($hotels as $hotel)
    <!-- Add map marker with hotel data -->
    <a href="{{ route('hotel-details', $hotel->id) }}">{{ $hotel->name }}</a>
@endforeach
```

### hotel-details.blade.php
**Location**: `resources/views/hotel-details.blade.php`

**Changes Required**:
1. Replace hardcoded "Hotel Plaza Athenee" with `{{ $hotel->name }}`
2. Replace hardcoded description with `{{ $hotel->description }}`
3. Replace hardcoded image with `{{ $hotel->image }}`
4. Update "Edit" link to point to `route('hotel-booking', $hotel->id)` instead of hardcoded link

### hotel-booking.blade.php
**Location**: `resources/views/hotel-booking.blade.php`

**Changes Required**:
1. Update form action to `{{ route('hotel-booking.store') }}`
2. Add hidden input: `<input type="hidden" name="hotel_id" value="{{ $hotel->id }}">`
3. Display `{{ $hotel->name }}` in "Review Order Details" section
4. Update image reference to `{{ $hotel->image }}`

---

## 2. Car Templates

**Status**: Templates likely already working, verify:
- car-grid.blade.php displays results
- car-details.blade.php shows car details
- car-booking.blade.php has correct form action

**Check**:
- Verify links use proper route names with IDs
- Verify form submissions go to correct endpoints

---

## 3. Cruise Templates

### cruise-grid.blade.php, cruise-list.blade.php, cruise-map.blade.php
**Apply same pattern as hotel templates**

**Loop variable**: `$cruises` 
**Route names**: `cruise-details`, `cruise-booking`, `cruise-booking.store`
**Model field mapping**:
- name → `$cruise->name`
- destination → `$cruise->destination`
- image → `$cruise->image`
- price → `$cruise->price`

### cruise-details.blade.php
**Display**: `$cruise` data
**Link**: `route('cruise-booking', $cruise->id)`

### cruise-booking.blade.php
**Hidden input**: `<input type="hidden" name="cruise_id" value="{{ $cruise->id }}">`
**Form action**: `route('cruise-booking.store')`

---

## 4. Tour Templates

### tour-grid.blade.php, tour-list.blade.php, tour-map.blade.php
**Apply same pattern as hotel templates**

**Loop variable**: `$tours`
**Route names**: `tour-details`, `tour-booking`, `tour-booking.store`
**Model field mapping**:
- name → `$tour->name`
- destination → `$tour->destination`
- image → `$tour->image`
- price → `$tour->price`

### tour-details.blade.php
**Display**: `$tour` data
**Link**: `route('tour-booking', $tour->id)`

### tour-booking.blade.php
**Hidden input**: `<input type="hidden" name="tour_id" value="{{ $tour->id }}">`
**Form action**: `route('tour-booking.store')`

---

## 5. Bus Templates

### bus-list.blade.php
**Loop variable**: `$buses`
**Route pattern**: Links to `route('bus-details', $bus->id)`

```blade
@forelse($buses as $bus)
    <div class="bus-item">
        <h5><a href="{{ route('bus-details', $bus->id) }}">{{ $bus->name }}</a></h5>
        <p>{{ $bus->from_location }} → {{ $bus->to_location }}</p>
        <p>${{ $bus->price }}</p>
    </div>
@empty
    <p>No buses found</p>
@endforelse
```

### bus-left-sidebar.blade.php, bus-right-sidebar.blade.php
**Optional components** - Only if needed for bus listing layout
- Can be used to display filters, schedule, amenities
- Not required for basic flow

### bus-details.blade.php
**Display**: `$bus` data
**Link**: `route('bus-booking', $bus->id)`

### bus-booking.blade.php
**Hidden input**: `<input type="hidden" name="bus_id" value="{{ $bus->id }}">`
**Form action**: `route('bus-booking.store')`

---

## Testing Checklist

For each booking flow, test:
- [ ] Search form in index.blade.php works
- [ ] Parameters pass to controller method
- [ ] Grid/List view displays items correctly
- [ ] View toggle links (grid/list/map) work
- [ ] Clicking item goes to details page
- [ ] Details page displays correct data
- [ ] "Book Now" button goes to booking form
- [ ] Booking form submission works
- [ ] Confirmation page displays

---

## Database Seeding

Before testing, ensure you have sample data:

```php
// In DatabaseSeeder or specific seeders

// Hotels
Hotel::factory(20)->create();

// Cruises
Cruise::factory(15)->create();

// Tours
Tour::factory(25)->create();

// Buses
Bus::factory(30)->create();
```

Create factory files if they don't exist:
- `database/factories/HotelFactory.php`
- `database/factories/CruiseFactory.php`
- `database/factories/TourFactory.php`
- `database/factories/BusFactory.php`

---

## Common Issues & Solutions

### Issue: "Undefined variable: hotels"
**Solution**: Ensure controller method passes variable to view:
```php
return view('hotel-grid', compact('hotels'));
```

### Issue: "Target class does not exist"
**Solution**: Ensure controller class is properly namespaced:
```php
namespace App\Http\Controllers;
```

### Issue: Route not working
**Solution**: Clear route cache:
```bash
php artisan route:cache
php artisan route:clear
```

### Issue: Session not persisting between pages
**Solution**: Ensure session is stored in controller:
```php
$request->session()->put('key', $value);
```

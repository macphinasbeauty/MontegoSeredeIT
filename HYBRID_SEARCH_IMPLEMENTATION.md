# Hybrid Search Implementation Guide

## Overview

The booking system now implements **truly hybrid search** across all services (Hotels, Cars, Buses, Tours). Each service searches both external APIs and the local database, combining results intelligently with source identification.

**Key Principle:** No dummy/hardcoded data. Services return ONLY:
1. **API Results** (if provider is active and has valid credentials)
2. **Database Results** (agent-added content, always available)

---

## Architecture Pattern

Each service follows this unified hybrid search pattern:

```php
public function search($params) {
    $apiResults = [];
    $dbResults = [];
    
    // 1. Try API search (if provider active)
    if ($this->provider && $this->provider->is_active) {
        try {
            $apiResults = $this->searchFromAPI($params);
        } catch (\Exception $e) {
            Log::warning('API search failed: ' . $e->getMessage());
        }
    }
    
    // 2. Always search database (fallback + agent content)
    try {
        $dbResults = $this->searchFromDatabase($params);
    } catch (\Exception $e) {
        Log::warning('DB search failed: ' . $e->getMessage());
    }
    
    // 3. Combine results with source identification
    $combined = [];
    foreach($apiResults as $r) { 
        $r['source'] = 'api'; 
        $r['source_name'] = 'Provider Name'; 
        $combined[] = $r; 
    }
    foreach($dbResults as $r) { 
        $r['source'] = 'database'; 
        $r['source_name'] = 'Direct Booking'; 
        $combined[] = $r; 
    }
    
    return [
        'data' => $combined,
        'api_count' => count($apiResults),
        'database_count' => count($dbResults),
        'total' => count($combined)
    ];
}
```

---

## Services Implemented

### 1. AmadeusHotelService (Hotels)

**Location:** `app/Services/AmadeusHotelService.php`

**Search Methods:**
- `searchHotels($params)` - Orchestrator method
- `searchHotelsFromAPI($params)` - Private API call
- `searchHotelsFromDatabase($params)` - Private DB query

**Database Filtering:**
```php
Hotel::where('destination', 'like', '%'.$params['destination'].'%')
    ->where('price_per_night', '>=', $params['min_price'])
    ->where('price_per_night', '<=', $params['max_price'])
    ->where('rating', '>=', $params['min_rating'])
    ->where('is_active', true)
    ->get();
```

**Result Tags:**
- API Results: `'source' => 'api'`, `'source_name' => 'Amadeus'`, ID format: `12345`
- DB Results: `'source' => 'database'`, `'source_name' => 'Direct Booking'`, ID format: `db_1`

---

### 2. AmadeusCarService (Car Rentals)

**Location:** `app/Services/AmadeusCarService.php`

**Search Methods:**
- `searchCars($params)` - Orchestrator
- `searchCarsFromAPI($params)` - Private API call
- `searchCarsFromDatabase($params)` - Private DB query

**Database Filtering:**
```php
Car::where('location', 'like', '%'.$params['location'].'%')
    ->where('daily_rate', '>=', $params['min_price'])
    ->where('daily_rate', '<=', $params['max_price'])
    ->where('available_count', '>', 0)
    ->where('is_active', true)
    ->get();
```

**Result Tags:**
- API Results: `'source' => 'api'`, `'source_name' => 'Amadeus'`
- DB Results: `'source' => 'database'`, `'source_name' => 'Direct Booking'`, ID: `db_X`

---

### 3. BusbudService (Buses)

**Location:** `app/Services/BusbudService.php`

**Search Methods:**
- `searchBuses($params)` - Orchestrator
- `searchBusesFromAPI($params)` - Private API call
- `searchBusesFromDatabase($params)` - Private DB query

**Database Filtering:**
```php
Bus::where('from_location', 'like', '%'.$params['from'].'%')
    ->where('to_location', 'like', '%'.$params['to'].'%')
    ->whereDate('departure_date', $params['date'])
    ->where('price', '>=', $params['min_price'])
    ->where('available_seats', '>', 0)
    ->where('is_active', true)
    ->get();
```

**Result Tags:**
- API Results: `'source' => 'api'`, `'source_name' => 'Busbud'`
- DB Results: `'source' => 'database'`, `'source_name' => 'Direct Booking'`, ID: `db_X`

---

### 4. ViatorService (Tours/Activities)

**Location:** `app/Services/ViatorService.php`

**Search Methods:**
- `searchActivities($params)` - Orchestrator
- `searchActivitiesFromAPI($params)` - Private API call
- `searchActivitiesFromDatabase($params)` - Private DB query

**Database Filtering & Sorting:**
```php
Tour::where('destination', 'like', '%'.$params['destination'].'%')
    ->where('price', '>=', $params['min_price'])
    ->where('price', '<=', $params['max_price'])
    ->where('is_active', true)
    ->orderBy($sortBy, 'desc') // POPULARITY|RATING|PRICE
    ->get();
```

**Result Tags:**
- API Results: `'source' => 'api'`, `'source_name' => 'Viator'`
- DB Results: `'source' => 'database'`, `'source_name' => 'Direct Booking'`, ID: `db_X`

---

## Controller Updates

All controllers now pass source count information to views:

### HotelBookingController
```php
$apiResponse = $this->hotelService->searchHotels($params);
$hotels = $this->hotelService->parseSearchResults($apiResponse);
$apiCount = $apiResponse['api_count'] ?? 0;
$dbCount = $apiResponse['database_count'] ?? 0;

return view('hotel-grid', compact('hotels', 'apiCount', 'dbCount'));
```

### AmadeusCarBookingController (NEW)
Same pattern for car rentals via Amadeus API + database

### BusBookingController
```php
$apiResponse = $this->busService->searchBuses($params);
$buses = $this->busService->parseSearchResults($apiResponse);
$apiCount = $apiResponse['api_count'] ?? 0;
$dbCount = $apiResponse['database_count'] ?? 0;

return view('bus-list', compact('buses', 'apiCount', 'dbCount'));
```

### TourBookingController
Same pattern for tours via Viator API + database

---

## Blade Template Updates

Update your views to display source badges and information:

### Example: hotel-grid.blade.php
```php
@foreach($hotels as $hotel)
    <div class="hotel-card">
        <div class="source-badge">
            @if($hotel['source'] === 'api')
                <span class="badge badge-blue">{{ $hotel['source_name'] }}</span>
            @else
                <span class="badge badge-green">Direct Booking</span>
            @endif
        </div>
        <h3>{{ $hotel['name'] }}</h3>
        <p>{{ $hotel['location'] ?? $hotel['city'] }}</p>
        <span class="price">${{ $hotel['price'] ?? $hotel['price_per_night'] }}</span>
        @if(isset($hotel['rating']))
            <span class="rating">⭐ {{ $hotel['rating'] }}</span>
        @endif
    </div>
@endforeach

<div class="search-stats">
    <p>Total Results: {{ count($hotels) }} ({{ $apiCount }} from Amadeus, {{ $dbCount }} from Direct Bookings)</p>
</div>
```

### Example: bus-list.blade.php
```php
@foreach($buses as $bus)
    <div class="bus-card">
        <span class="source {{ $bus['source'] }}">
            {{ $bus['source_name'] }}
        </span>
        <h4>{{ $bus['from_location'] }} → {{ $bus['to_location'] }}</h4>
        <p>{{ $bus['departure_date'] }}</p>
        <span class="price">${{ $bus['price'] }}</span>
    </div>
@endforeach
```

---

## Database Models

Agents can add content through these models:

### Hotel Model
```php
$hotel = Hotel::create([
    'name' => 'Beach Resort',
    'location' => 'Mombasa',
    'city' => 'Mombasa',
    'price_per_night' => 150,
    'rating' => 4.5,
    'description' => '...',
    'is_active' => true,
]);
```

### Car Model
```php
$car = Car::create([
    'type' => 'SUV',
    'model' => 'Toyota Land Cruiser',
    'location' => 'Nairobi',
    'daily_rate' => 100,
    'seats' => 5,
    'available_count' => 3,
    'is_active' => true,
]);
```

### Bus Model
```php
$bus = Bus::create([
    'from_location' => 'Nairobi',
    'to_location' => 'Mombasa',
    'departure_date' => '2024-12-25',
    'price' => 50,
    'available_seats' => 10,
    'is_active' => true,
]);
```

### Tour Model
```php
$tour = Tour::create([
    'destination' => 'Mount Kenya',
    'title' => 'Mount Kenya Climb',
    'price' => 500,
    'rating' => 4.8,
    'duration_minutes' => 1440,
    'category' => 'hiking',
    'is_active' => true,
]);
```

---

## API Configuration

Each service checks if API is active before searching:

### Setting Up APIs

**For Amadeus (Hotels & Cars):**
```php
$provider = Provider::create([
    'name' => 'Amadeus',
    'api_key' => 'your_api_key',
    'api_secret' => 'your_api_secret',
    'is_active' => true,
]);
```

**For Busbud (Buses):**
```php
$provider = Provider::create([
    'name' => 'Busbud',
    'api_key' => 'your_api_key',
    'is_active' => true,
]);
```

**For Viator (Tours):**
```php
$provider = Provider::create([
    'name' => 'Viator',
    'api_key' => 'your_api_key',
    'is_active' => true,
]);
```

---

## Search Flow Diagram

```
User Search Request
        ↓
    ┌───┴────────────────────┐
    ↓                        ↓
API Search (if active)  Database Search (always)
    ↓                        ↓
Process API Results    Process DB Results
    ↓                        ↓
Tag with source='api'   Tag with source='database'
Tag with provider name  Tag with 'Direct Booking'
    ↓                        ↓
    └───────────┬────────────┘
                ↓
          Combine Results
                ↓
      Count API vs DB
                ↓
        Return to Controller
                ↓
          Parse Results
                ↓
        Pass to Blade View
                ↓
    Display with Source Badges
```

---

## Result Object Structure

```json
{
    "data": [
        {
            "id": "12345",
            "name": "Hotel Name",
            "price": 150,
            "source": "api",
            "source_name": "Amadeus",
            ...other fields...
        },
        {
            "id": "db_1",
            "name": "Agent's Hotel",
            "price": 120,
            "source": "database",
            "source_name": "Direct Booking",
            ...other fields...
        }
    ],
    "api_count": 25,
    "database_count": 3,
    "total": 28
}
```

---

## Testing Hybrid Search

### Step 1: Add Sample Database Records
```php
// Create a test hotel
Hotel::create([
    'name' => 'Test Hotel',
    'location' => 'New York',
    'price_per_night' => 100,
    'rating' => 4.5,
    'is_active' => true,
]);

// Create a test car
Car::create([
    'type' => 'Sedan',
    'model' => 'Toyota Camry',
    'location' => 'Los Angeles',
    'daily_rate' => 75,
    'seats' => 5,
    'available_count' => 2,
    'is_active' => true,
]);
```

### Step 2: Test Without API (Database Only)
- Disable API or don't set credentials
- Search should return only database results
- Source should be 'database' and 'Direct Booking'

### Step 3: Test With API (Combined)
- Enable API with valid credentials
- Search should return both API and database results
- Source tags should differentiate them

### Step 4: Verify Result Counts
- Check `apiCount` and `dbCount` match expectations
- Verify total = apiCount + dbCount

---

## Fallback Behavior

### API Fails
```
searchHotels()
├─ Try searchHotelsFromAPI() → FAILS (no internet, invalid key, etc)
├─ Continue (no error thrown)
├─ searchHotelsFromDatabase() → SUCCESS
└─ Return database results only (apiCount=0)
```

### Database Query Fails
```
searchHotels()
├─ searchHotelsFromAPI() → SUCCESS
├─ Try searchHotelsFromDatabase() → FAILS
├─ Continue (no error thrown)
└─ Return API results only (dbCount=0)
```

### Both Fail
```
searchHotels()
├─ Both fail
└─ Return empty array (graceful degradation)
```

---

## ID Handling

### API IDs
- Original API IDs preserved
- Examples: `'12345'`, `'hotel_xyz'`

### Database IDs
- Prefixed with `'db_'`
- Examples: `'db_1'`, `'db_25'`
- Used in routes to identify source:
  ```php
  if (strpos($id, 'db_') === 0) {
      // Query database
      $carId = str_replace('db_', '', $id);
      $car = Car::find($carId);
  } else {
      // Query API
      $car = $this->carService->getCarDetails($id);
  }
  ```

---

## Performance Considerations

1. **Parallel Searches** (Optional)
   - Can use `collect()` or async for parallel API + DB queries
   - Currently sequential for simplicity

2. **Caching**
   - API results can be cached by location/date
   - Example: `Cache::remember('hotels_NYC', 3600, function() {...})`

3. **Pagination**
   - Consider paginating combined results
   - Sort by relevance/price before splitting into pages

4. **Filtering**
   - Apply price/rating filters to both sources
   - Ensure consistent filtering logic

---

## Summary

**Hybrid Search = API + Database**
- No dummy data
- Agent-added content always available
- Source identification for transparency
- Graceful fallbacks
- Database-first when API unavailable
- Scalable and maintainable

**Controllers Updated:**
- HotelBookingController (grid, list, map)
- AmadeusCarBookingController (grid, list, map) - NEW
- BusBookingController (list)
- TourBookingController (grid, list)

**Services Updated:**
- AmadeusHotelService
- AmadeusCarService
- BusbudService
- ViatorService

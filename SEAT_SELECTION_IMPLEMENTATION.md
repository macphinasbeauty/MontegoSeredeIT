# Custom Seat Selection System - Complete Implementation

## Overview
A comprehensive, enterprise-grade seat selection system supporting both Duffel and Amadeus APIs with custom UI rendering, smart family seating, and airline rule validation.

---

## 1. Database Schema Updates

### Migration: `2024_01_09_add_seat_details_to_bookings.php`

**New Columns:**
- `seat_details` (JSON): Stores selected seats with service IDs and passenger assignments
  ```json
  [
    {
      "service_id": "seat_123abc",
      "designator": "14A",
      "price": 25.00,
      "passenger_index": 0
    }
  ]
  ```

- `pnr` (string): Booking Reference Number (unique)
- `order_id` (string): Order ID from flight API provider

**Run Migration:**
```bash
php artisan migrate
```

---

## 2. FlightApiService Enhancements

### New Methods Added:

#### `getSeatMap($offerId)`
- Fetches raw seat map data from Duffel API
- **Endpoint**: `GET /air/seat_maps?offer_id={offerId}`
- **Returns**: Array of cabin objects with rows and seats

#### `processDuffelSeatMap($seatMaps)`
- Converts raw Duffel JSON into structured format for UI rendering
- **Structure**:
  ```php
  [
    'economy' => [
      'cabin_class' => 'economy',
      'rows' => [
        [
          'row_number' => 14,
          'sections' => [
            [
              'name' => 'main',
              'seats' => [
                [
                  'designator' => '14A',
                  'available' => true,
                  'service_id' => 'seat_xyz',
                  'price' => 0,
                  'characteristics' => ['extra_legroom']
                ]
              ]
            ]
          ]
        ]
      ],
      'stats' => [
        'total' => 180,
        'available' => 45,
        'occupied' => 135
      ]
    ]
  ]
  ```

#### `getAmadeusSeatMap($flightOfferId)`
- Fetches seat map from Amadeus SeatMap Display API
- **Endpoint**: `GET /shopping/seatmaps`
- Provides alternative provider support

#### `processAmadeusSeatMap($seatMaps)`
- Unifies Amadeus response into same format as Duffel
- Ensures consistent UI rendering across providers

#### `findGroupSeating($processedCabins, $groupSize = 2)`
- **Smart Algorithm**: Identifies consecutive empty seats
- **Returns**: Array of seating recommendations for families
- **Features**:
  - Finds groups of adjacent seats in same row
  - Validates consecutive positions (14A, 14B, 14C)
  - Calculates total group pricing
  - Tags as 'couple' (2 seats) or 'family' (3+ seats)

#### `validateSeatSelection($selectedSeats, $passengers)`
- **Airline Rule Validation**:
  - ❌ Prevents infants from having separate seats
  - ❌ Blocks children/infants in exit rows (rows 1, 10, 15)
  - ✅ Validates passenger-to-seat mapping
  - ✅ Returns user-friendly error messages

---

## 3. FlightController Methods

### `seatSelection($provider, $flightId)`
- **Flow**:
  1. Retrieve flight from session or API
  2. Fetch seat map based on provider (Duffel/Amadeus)
  3. Process raw data into structured cabins
  4. Generate smart seating recommendations
  5. Pass to view for rendering

- **Returns**: Custom seat selection view with:
  - Processed cabin data
  - Group recommendations
  - Graceful fallback for unavailable seat maps

### `saveSeatSelection(Request $request)`
- **Validation**:
  - Parses JSON seat selections
  - Validates against airline rules
  - Prevents duplicate bookings

- **Actions**:
  - Stores selected seats in session (JSON)
  - Redirects to flight-booking page
  - Handles skip-seats option

---

## 4. Custom UI Implementation

### View: `flight-seat-selection-custom.blade.php`

#### Key Features:

**Flight Summary**
- Airline name and code
- Route (origin → destination)
- Passenger count

**Smart Group Recommendations**
```
Perfect for Families - Recommended Seating
Row 14 (Couple): Seats 14A, 14B - $0.00
Row 15 (Family): Seats 15A, 15B, 15C - $25.00
```
- Click to auto-select group
- Shows total pricing

**Custom Seat Map Rendering**
- **Monospace grid layout** with:
  - Row numbers on both sides
  - Section dividers (e.g., A/B | C/D)
  - Individual seat buttons
  - Real-time selection feedback

- **Seat States**:
  - `available` (white): Clickable
  - `occupied` (gray): Disabled
  - `selected` (blue): User choice
  - `extra-legroom` (green): Premium seats

**Interactive Features**:
- ✅ Click seats to select/deselect
- ✅ Limit selections to passenger count
- ✅ Show total seat charges
- ✅ Display passenger type per seat (Adult/Child/Infant)
- ✅ Skip seats button with confirmation
- ✅ Keyboard accessible

---

## 5. Data Flow & Integration

### Complete Booking Journey:

```
1. Flight Details Page
   ↓ (Click "Book Now")
2. Seat Selection Page
   ├─ Duffel Flow:
   │  ├─ GET /air/seat_maps?offer_id=...
   │  └─ processDuffelSeatMap()
   ├─ Amadeus Flow:
   │  ├─ GET /shopping/seatmaps
   │  └─ processAmadeusSeatMap()
   ├─ Smart Recommendations
   │  └─ findGroupSeating()
   └─ Custom UI Rendering
   ↓
3. Save Seat Selection
   ├─ validateSeatSelection()
   └─ session(['selected_seats' => ...])
   ↓
4. Flight Booking Page
   └─ Show selected seats confirmation
   ↓
5. Flight Confirmation
   └─ Store in database (seat_details JSON)
```

---

## 6. Seat Details Storage

### Database Structure:
```sql
-- bookings table
seat_details JSON
pnr VARCHAR(50) UNIQUE
order_id VARCHAR(100)
```

### Example Storage:
```json
{
  "seat_details": [
    {
      "service_id": "seat_offer_123abc",
      "designator": "14A",
      "price": 0.00,
      "passenger_name": "John Doe",
      "passenger_type": "adult"
    },
    {
      "service_id": "seat_offer_456def",
      "designator": "14B",
      "price": 25.00,
      "passenger_name": "Jane Doe",
      "passenger_type": "adult"
    }
  ],
  "pnr": "ABC123XYZ",
  "order_id": "order_789ghi"
}
```

---

## 7. Email Confirmation (Future Implementation)

### Mailable: `SeatConfirmation.php`

**Email Content**:
```
Flight Booking Confirmation
===========================

Booking Reference: ABC123XYZ
Flight: UA001 (United Airlines)
Route: JFK → LAX
Departure: Jan 20, 2026 10:30 AM

Passengers & Seats:
- John Doe............ Seat 14A
- Jane Doe............ Seat 14B
- Sarah Doe.......... Seat 15A (Child)

Total Seat Charges: $25.00
```

**Schema.org Markup**:
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FlightReservation",
  "reservationNumber": "ABC123XYZ",
  "underName": "John Doe",
  "reservationFor": {
    "@type": "Flight",
    "flightNumber": "UA001",
    "airline": { "@type": "Airline", "name": "United Airlines" },
    "departureAirport": { "@type": "Airport", "iataCode": "JFK" },
    "arrivalAirport": { "@type": "Airport", "iataCode": "LAX" },
    "departureTime": "2026-01-20T10:30:00",
    "arrivalTime": "2026-01-20T13:30:00"
  },
  "passengerSequenceNumber": "1",
  "passengerPriorityStatus": "BusinessClass",
  "securityScreening": "https://example.com/check-in",
  "boardingGroup": "A",
  "seatNumber": "14A"
}
</script>
```

---

## 8. Revenue Opportunities

### Monetization Strategy:

1. **Seat Markup Pricing**
   - Duffel Base: $0
   - Your Markup: +$5.00
   - Customer Pays: $5.00

2. **Premium Seat Upsell**
   - Extra Legroom: +$15-25
   - Exit Row: +$10-20
   - Bulkhead: +$20-30

3. **Convenience Fee**
   - Seat Selection Service: +$2-5 per booking
   - Family Grouping Assistance: +$3-7

4. **Analytics Benefit**
   - Track most popular seats
   - Optimize airline negotiations
   - Personalize future recommendations

### Expected Revenue per 100 Bookings:
- 60 passengers select seats @ $5 = $300
- 15 premium upgrades @ $15 = $225
- 100 convenience fee @ $3 = $300
- **Total: $825/100 bookings**

---

## 9. Testing & Deployment

### Run Migration:
```bash
php artisan migrate
```

### Test Seat Selection:
1. Go to flight-details page
2. Click "Book Now"
3. View custom seat map
4. Select seats (verify smart recommendations)
5. Submit and check session data
6. Verify booking confirmation shows seats

### API Testing:
```bash
# Test Duffel seat map
curl -H "Authorization: Bearer DUFFEL_KEY" \
  https://api.duffel.com/air/seat_maps?offer_id=offer_123

# Test Amadeus seat map
curl -H "Authorization: Bearer AMADEUS_TOKEN" \
  https://api.amadeus.com/v2/shopping/seatmaps?flightOfferId=1
```

---

## 10. File References

**Created/Modified Files:**
- ✅ `database/migrations/2024_01_09_add_seat_details_to_bookings.php`
- ✅ `app/Services/FlightApiService.php` (enhanced)
- ✅ `app/Http/Controllers/FlightController.php` (seatSelection, saveSeatSelection)
- ✅ `resources/views/flight-seat-selection-custom.blade.php` (custom UI)
- ✅ `routes/web.php` (seat selection routes)
- ✅ `resources/views/flight-details.blade.php` (updated form action)

---

## 11. Troubleshooting

### Issue: "No seat map available"
- **Cause**: Airline doesn't support digital seat selection
- **Solution**: Gracefully fall back to skip-seats option

### Issue: Seats not showing correctly
- **Cause**: Raw JSON structure doesn't match expected format
- **Solution**: Verify API response in `processDuffelSeatMap()` / `processAmadeusSeatMap()`

### Issue: Group recommendations not appearing
- **Cause**: No consecutive empty seats found
- **Solution**: Check `findGroupSeating()` logic and seat availability

---

## 12. Future Enhancements

- [ ] Post-booking seat changes (Order Change API)
- [ ] Seat swap between passengers
- [ ] Seat insurance/seat guarantee
- [ ] Historical seat popularity heatmap
- [ ] ML-based family seating suggestions
- [ ] Mobile app integration
- [ ] Real-time seat availability updates
- [ ] Accessibility seat recommendations

---

**Implementation Complete! 🎉**

This system provides a production-ready seat selection experience that maximizes revenue while ensuring compliance with airline rules and exceptional UX.

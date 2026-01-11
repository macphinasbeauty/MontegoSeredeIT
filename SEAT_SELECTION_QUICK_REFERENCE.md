# Seat Selection - Quick Reference Guide

## 🚀 Getting Started

### 1. Run Database Migration
```bash
php artisan migrate
```
This adds `seat_details`, `pnr`, and `order_id` columns to bookings table.

---

## 📋 API Endpoints

### Duffel Seat Map
```
GET /air/seat_maps?offer_id={offerId}
Authorization: Bearer {DUFFEL_API_KEY}
Duffel-Version: v2
```

### Amadeus Seat Map
```
GET /shopping/seatmaps?flightOfferId={offerId}
Authorization: Bearer {AMADEUS_TOKEN}
```

---

## 🔄 Complete User Flow

```
1. Flight Details
   ↓
2. Click "Book Now" → Redirects to Seat Selection
   ↓
3. Seat Selection Page
   ├─ View custom seat map grid
   ├─ Click seats to select
   ├─ See group recommendations (families)
   └─ Skip seats option available
   ↓
4. Click "Continue to Booking"
   ├─ Validates seat selection
   └─ Stores in session
   ↓
5. Flight Booking Page
   ├─ Shows selected seats confirmation
   ├─ Fill passenger details
   └─ Continue to payment
   ↓
6. Flight Confirmation
   └─ Store seat details in database
```

---

## 💾 Database Schema

### Bookings Table Updates
```sql
ALTER TABLE bookings ADD seat_details JSON;
ALTER TABLE bookings ADD pnr VARCHAR(50) UNIQUE;
ALTER TABLE bookings ADD order_id VARCHAR(100);
```

### Stored Data Format
```json
{
  "selected_seats": [
    {
      "service_id": "seat_ABC123",
      "designator": "14A",
      "price": 25.00,
      "passenger_type": "adult"
    }
  ],
  "total_seat_charges": 25.00,
  "group_selected": false
}
```

---

## 🎨 UI Features

### Seat Map Grid
- **Available**: White (clickable)
- **Occupied**: Gray (disabled)
- **Selected**: Blue
- **Extra Legroom**: Green

### Smart Recommendations
- Automatically suggests family groups
- Shows available adjacent seats
- Displays total pricing per group
- One-click select button

### Form Validation
- Enforces seat count = passenger count
- Validates airline rules:
  - ❌ Children/infants can't sit in exit rows
  - ❌ Infants don't need separate seats
- User-friendly error messages

---

## 🛠️ API Service Methods

### FlightApiService

```php
// Get raw seat map from API
$rawMap = $service->getSeatMap($offerId);

// Process Duffel format
$processed = $service->processDuffelSeatMap($rawMap);

// Process Amadeus format
$processed = $service->processAmadeusSeatMap($rawMap);

// Find family seating groups
$groups = $service->findGroupSeating($processed, 3); // 3-person groups

// Validate selections
$errors = $service->validateSeatSelection($seats, $passengers);
```

---

## 🎯 Controller Flow

### seatSelection($provider, $flightId)
1. Fetch flight from session
2. Get seat map from API
3. Process data for UI
4. Find group recommendations
5. Return view

### saveSeatSelection(Request $request)
1. Parse JSON selections
2. Validate against rules
3. Store in session
4. Redirect to booking

---

## 💰 Revenue Model

### Pricing Strategy
| Feature | Price |
|---------|-------|
| Base Seat Selection | $0-5 |
| Extra Legroom | +$15-25 |
| Exit Row | +$10-20 |
| Bulkhead | +$20-30 |
| Convenience Fee | +$2-5 |

### Projected Revenue
- 60% seat selection adoption
- 15% premium seat upgrade
- Expected: $300-400 per 100 bookings

---

## 🔍 Troubleshooting

### "Seat Selection Unavailable"
- Airline doesn't support digital seat selection
- User can skip and select on airline website post-booking
- Don't force selection - maintain good UX

### Seats Not Displaying
- Check API response structure
- Verify `processXxxSeatMap()` parsing
- Log raw API response for debugging

### Group Recommendations Missing
- No consecutive empty seats found
- That's okay - not all flights have good groups
- Show what's available

### Seat Validation Failing
- Check passenger type (adult/child/infant)
- Validate row numbers (exit rows: 1, 10, 15)
- Show specific error to user

---

## 📱 Mobile Optimization

The seat map is responsive:
- Scrollable on small screens
- Touch-friendly seat buttons
- Stack sidebar below on mobile
- Full functionality maintained

---

## 🔐 Security Considerations

1. **Validate on Backend**
   - Don't trust client-side selections
   - Verify seat_id and offer_id match

2. **Rate Limiting**
   - Implement on seat-selection endpoint
   - Prevent abuse/scanning all seats

3. **Session Validation**
   - Check selected seats before booking confirmation
   - Validate passenger count matches

4. **API Key Protection**
   - Store in .env file
   - Never expose in frontend code
   - Use separate API keys per provider

---

## 📊 Analytics to Track

```php
// Store analytics for optimization
Event::dispatch(new SeatSelectionAnalytics([
    'provider' => 'duffel',
    'seats_selected' => 2,
    'total_seats' => 180,
    'premium_seats_selected' => 1,
    'total_charge' => 25.00,
    'skip_selected' => false,
    'time_to_select' => 45, // seconds
]));
```

---

## 🧪 Test Cases

```php
// Test smart recommendations
$groups = $service->findGroupSeating($cabins, 3);
$this->assertNotEmpty($groups);

// Test validation
$errors = $service->validateSeatSelection(
    $seats, 
    [['type' => 'child'], ['type' => 'adult']]
);
$this->assertEmpty($errors);

// Test seat limiting
// Verify can't select more than passenger count
```

---

## 📝 Next Steps

1. ✅ Run migration
2. ✅ Test with sample flight
3. ✅ Verify seat map displays correctly
4. ✅ Test group recommendations
5. ✅ Configure API keys
6. ✅ Test validation
7. ✅ Add email confirmation
8. ✅ Monitor analytics
9. ⏭️ Implement seat change flow
10. ⏭️ Add post-booking seat management

---

**Happy Booking! 🎫**

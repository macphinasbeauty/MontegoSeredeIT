<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'booking_id',
        'user_id',
        'amount',
        'currency_id',
        'status',
        'invoice_date',
        'description',
        'items'
    ];

    protected $casts = [
        'items' => 'array',
        'invoice_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}

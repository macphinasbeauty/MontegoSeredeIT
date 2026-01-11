<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'agent_id',
        'bookable_type',
        'bookable_id',
        'check_in',
        'check_out',
        'departure_date',
        'return_date',
        'status',
        'total_price',
        'currency_id',
        'details',
        'payment_gateway_id',
    ];

    protected $casts = [
        'details' => 'array',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function bookable()
    {
        return $this->morphTo();
    }
}

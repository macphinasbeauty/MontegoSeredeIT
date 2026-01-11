<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    // Support alternative schema: older migrations used 'config' and 'is_active'
    protected $fillable = ['name', 'enabled', 'settings', 'provider', 'config', 'is_active'];

    protected $casts = [
        'enabled' => 'boolean',
        'settings' => 'array',
        'is_active' => 'boolean',
        'config' => 'array',
    ];
}

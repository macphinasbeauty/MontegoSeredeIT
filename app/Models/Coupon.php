<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_amount',
        'max_discount',
        'usage_limit',
        'usage_count',
        'per_user_limit',
        'starts_at',
        'expires_at',
        'is_active',
        'applicable_services',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'per_user_limit' => 'integer',
        'starts_at' => 'date',
        'expires_at' => 'date',
        'is_active' => 'boolean',
        'applicable_services' => 'array',
    ];

    /**
     * Check if coupon is valid for use
     */
    public function isValid($service = 'tours', $userId = null, $amount = 0)
    {
        // Check if coupon is active
        if (!$this->is_active) {
            return false;
        }

        // Check date validity
        $now = Carbon::now();
        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }
        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        // Check usage limit
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        // Check minimum amount
        if ($this->min_amount > 0 && $amount < $this->min_amount) {
            return false;
        }

        // Check applicable services
        if ($this->applicable_services && !in_array($service, $this->applicable_services)) {
            return false;
        }

        // Check per user limit if user provided
        if ($userId && $this->per_user_limit > 0) {
            // This would require a coupon usage tracking table
            // For now, we'll skip this check
        }

        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            $discount = ($amount * $this->value) / 100;

            // Apply max discount limit if set
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }

            return $discount;
        } else {
            // Fixed amount discount
            return min($this->value, $amount); // Can't discount more than the amount
        }
    }

    /**
     * Apply coupon (increment usage count)
     */
    public function apply()
    {
        $this->increment('usage_count');
    }

    /**
     * Get formatted discount display
     */
    public function getFormattedDiscountAttribute()
    {
        if ($this->type === 'percentage') {
            return $this->value . '%';
        } else {
            return '$' . number_format($this->value, 2);
        }
    }

    /**
     * Scope for active coupons
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('starts_at')
                          ->orWhere('starts_at', '<=', Carbon::now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>=', Carbon::now());
                    });
    }

    /**
     * Scope for applicable to service
     */
    public function scopeForService($query, $service)
    {
        return $query->where(function ($q) use ($service) {
            $q->whereNull('applicable_services')
              ->orWhereJsonContains('applicable_services', $service);
        });
    }
}

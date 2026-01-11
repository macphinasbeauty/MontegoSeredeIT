<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertApplication extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'comments',
        'status',
        'approved_at',
        'approved_by',
        'admin_notes'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}

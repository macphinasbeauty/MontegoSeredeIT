<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLinkedAccount extends Model
{
    protected $table = 'user_linked_accounts';

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'name',
        'email',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'connected',
        'settings',
    ];

    protected $casts = [
        'connected' => 'boolean',
        'token_expires_at' => 'datetime',
        'settings' => 'array',
    ];

    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isConnected()
    {
        return $this->connected && $this->access_token;
    }

    public function isTokenExpired()
    {
        return $this->token_expires_at && $this->token_expires_at->isPast();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTwoFactor extends Model
{
    protected $table = 'user_two_factor';

    protected $fillable = [
        'user_id',
        'type',
        'identifier',
        'enabled',
        'secret',
        'backup_codes',
        'verified_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'backup_codes' => 'array',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isEnabled()
    {
        return $this->enabled && $this->verified_at;
    }
}

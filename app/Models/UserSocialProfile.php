<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocialProfile extends Model
{
    protected $table = 'user_social_profiles';

    protected $fillable = [
        'user_id',
        'platform',
        'profile_url',
        'profile_id',
        'verified',
        'metadata',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isVerified()
    {
        return $this->verified;
    }

    public function getProfileUrl()
    {
        if ($this->profile_url) {
            return $this->profile_url;
        }

        // Generate URL based on platform
        $baseUrls = [
            'facebook' => 'https://facebook.com/',
            'twitter' => 'https://twitter.com/',
            'instagram' => 'https://instagram.com/',
            'youtube' => 'https://youtube.com/@',
        ];

        if (isset($baseUrls[$this->platform]) && $this->profile_id) {
            return $baseUrls[$this->platform] . $this->profile_id;
        }

        return null;
    }
}

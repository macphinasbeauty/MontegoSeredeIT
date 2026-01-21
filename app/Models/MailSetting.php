<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    protected $fillable = [
        'mail_driver',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'mailgun_domain',
        'mailgun_secret',
        'mailgun_endpoint',
        'ses_key',
        'ses_secret',
        'ses_region',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'mail_port' => 'integer',
    ];

    /**
     * Get the active mail settings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the first active mail setting or create default
     */
    public static function getActive()
    {
        $setting = self::active()->first();

        if (!$setting) {
            $setting = self::create([
                'mail_driver' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => 587,
                'mail_encryption' => 'tls',
                'mail_from_name' => 'Miles Montego',
                'is_active' => false,
            ]);
        }

        return $setting;
    }
}

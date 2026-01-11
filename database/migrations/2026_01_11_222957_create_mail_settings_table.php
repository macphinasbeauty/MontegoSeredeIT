<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->id();
            $table->string('mail_driver')->default('smtp'); // smtp, mailgun, ses, etc.
            $table->string('mail_host')->nullable();
            $table->integer('mail_port')->default(587);
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_encryption')->default('tls'); // tls, ssl
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->default('DreamsTour');
            // Mailgun specific
            $table->string('mailgun_domain')->nullable();
            $table->string('mailgun_secret')->nullable();
            $table->string('mailgun_endpoint')->default('api.mailgun.net');
            // SES specific
            $table->string('ses_key')->nullable();
            $table->string('ses_secret')->nullable();
            $table->string('ses_region')->default('us-east-1');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_settings');
    }
};

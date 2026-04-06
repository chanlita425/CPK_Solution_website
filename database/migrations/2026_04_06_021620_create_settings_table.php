<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_url')->nullable();
            $table->string('company_phone_number_first')->nullable();
            $table->string('company_phone_number_second')->nullable();
            $table->string('company_logo')->nullable();
            $table->text('about_company')->nullable();
            $table->string('hero_banner_image')->nullable();
            $table->string('promotion_banner_image')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('telegram_link')->nullable();
            $table->string('tiktok_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->decimal('tax_percent', 5, 2)->default(0);
            $table->string('seller_telegram')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

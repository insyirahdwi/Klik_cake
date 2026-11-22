<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('networkings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('social_media'); // social_media, outlet, partner, reseller
            $table->string('platform')->nullable(); // instagram, tiktok, facebook, whatsapp, gmaps, web
            $table->string('url')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('networkings');
    }
};

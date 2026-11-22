<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('Fresh Bake hari ini');
            $table->string('title')->default('Klik, dipanggang, sampai.');
            $table->text('subtitle')->nullable();
            $table->string('button_text')->default('Pesan Sekarang');
            $table->string('button_link')->default('/katalog');
            $table->string('secondary_button_text')->nullable()->default('Lihat Menu');
            $table->string('secondary_button_link')->nullable()->default('#kategori');
            $table->string('image_url')->nullable();
            $table->foreignId('featured_product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CollectionSeeder::class,
            ProductSeeder::class,
            SlotQuotaSeeder::class,
            DeliveryZoneSeeder::class,
            PromoCodeSeeder::class,
            ArticleSeeder::class,
            PageSeeder::class,
            HeroSectionSeeder::class,
            WebSettingSeeder::class,
            NetworkingSeeder::class,
        ]);
    }
}

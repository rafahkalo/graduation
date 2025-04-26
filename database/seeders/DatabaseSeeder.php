<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            FeatureSeeder::class,
            LanguageSeeder::class,
            DirectionsSeeder::class,
            CountrySeeder::class,
            CategorySeeder::class,
            PropertySeeder::class,
            BusinessReviewsTableSeeder::class
        ]);
    }
}

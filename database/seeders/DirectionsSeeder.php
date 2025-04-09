<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DirectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directions = [
            [
                'id' => Str::uuid(),
                'name' => 'شمالي',
                'translation' => json_encode([
                    'en' => 'Northern',
                    'ar' => 'شمالي',
                ]),
                'status' => 'active'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'جنوبي',
                'translation' => json_encode([
                    'en' => 'Southern',
                    'ar' => 'جنوبي',
                ]),
                'status' => 'active'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'شرقي',
                'translation' => json_encode([
                    'en' => 'Eastern',
                    'ar' => 'شرقي',
                ]),
                'status' => 'active'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'غربي',
                'translation' => json_encode([
                    'en' => 'Western',
                    'ar' => 'غربي',
                ]),
                'status' => 'active'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'شمالي شرقي',
                'translation' => json_encode([
                    'en' => 'Northeastern',
                    'ar' => 'شمالي شرقي',
                ]),
                'status' => 'active'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'شمالي غربي',
                'translation' => json_encode([
                    'en' => 'Northwestern',
                    'ar' => 'شمالي غربي',
                ]),
                'status' => 'active'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'جنوبي شرقي',
                'translation' => json_encode([
                    'en' => 'Southeastern',
                    'ar' => 'جنوبي شرقي',
                ]),
                'status' => 'active'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'جنوبي غربي',
                'translation' => json_encode([
                    'en' => 'Southwestern',
                    'ar' => 'جنوبي غربي',
                ]),
                'status' => 'active'
            ],
        ];
        DB::table('directions')->insert($directions);
    }
}

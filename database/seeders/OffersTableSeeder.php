<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OffersTableSeeder extends Seeder
{
    public function run()
    {
        // Fetch all unit IDs from the units table
        $unitIds = DB::table('units')->where('status', 'active')->pluck('id')->toArray();

        // Sample data for offers
        $offers = [
            [
                'id' => Str::uuid(),
                'name' => 'Spring Sale',
                'num_usage' => 10,
                'remaining_usage' => 5,
                'status' => 'active',
                'type_offer' => 'percent',
                'value_offer' => 20,
                'from' => '2025-04-01',
                'to' => '2025-04-30',
                'unit_id' => !empty($unitIds) ? $unitIds[array_rand($unitIds)] : null, // Random unit_id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Black Friday Deal',
                'num_usage' => 50,
                'remaining_usage' => 25,
                'status' => 'active',
                'type_offer' => 'fixed',
                'value_offer' => 100,
                'from' => '2025-11-25',
                'to' => '2025-11-30',
                'unit_id' => !empty($unitIds) ? $unitIds[array_rand($unitIds)] : null, // Random unit_id
            ],
            // Add more offers as needed
        ];

        // Insert data into the offers table
        DB::table('offers')->insert($offers);
    }
}

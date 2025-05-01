<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BusinessReviewsTableSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('business_reviews')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get all users and tenants to associate with reviews
        $users = User::all();
        $tenants = Tenant::all();

        if ($users->isEmpty() || $tenants->isEmpty()) {
            $this->command->info('No users or tenants found! Please seed users and tenants first.');

            return;
        }

        $reasons = [
            'Great service, highly recommended!',
            'Average experience, could be better.',
            'Excellent communication and professionalism.',
            'Not satisfied with the quality of work.',
            'Went above and beyond expectations!',
            'Would not hire again.',
            'Very responsive and easy to work with.',
            'Completed the job quickly and efficiently.',
            'Had some issues with timeliness.',
            'Perfect in every way, 5 stars!',
            null, // Some reviews might not have a reason
        ];

        $reviews = [];

        for ($i = 0; $i < 100; $i++) { // Generate 100 reviews
            $reviews[] = [
                'id' => Str::uuid(),
                'reason' => $reasons[array_rand($reasons)],
                'rating' => mt_rand(10, 50) / 10, // Random rating between 1.0 and 5.0
                'tenant_id' => $tenants->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now()->subDays(rand(0, 90)),
                'updated_at' => now()->subDays(rand(0, 90)),
            ];
        }

        // Insert in chunks for better performance
        foreach (array_chunk($reviews, 50) as $chunk) {
            DB::table('business_reviews')->insert($chunk);
        }

        $this->command->info('Seeded 100 business reviews.');
    }
}

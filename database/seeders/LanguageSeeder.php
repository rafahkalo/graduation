<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'English',
                'code' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arabic',
                'code' => 'ar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($languages as $item) {
            Language::create($item);
        }
    }
}

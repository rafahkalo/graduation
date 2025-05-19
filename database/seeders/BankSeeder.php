<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            'Al Rajhi Bank',
            'National Commercial Bank',
            'SABB',
            'Riyad Bank',
            'Banque Saudi Fransi',
            'Alinma Bank',
            'Arab National Bank',
        ];

        foreach ($banks as $bankName) {
            DB::table('banks')->insert([
                'id' => Str::uuid(),
                'name' => $bankName,
            ]);
        }
    }
}

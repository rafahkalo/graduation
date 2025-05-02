<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Country;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $country = Country::all();

        DB::table('tenants')->insert([
            [
                'id' => Str::uuid(),
                'first_name' => 'Ali',
                'last_name' => 'Hassan',
                'national_id' => $country->random()->id,
                'birth_date' => '1990-01-01',
                'gender' => 'male',
                'phone' => '0500000001',
                'ide' => 'ID001',
            ],
            [
                'id' => Str::uuid(),
                'first_name' => 'Sara',
                'last_name' => 'Ahmad',
                'national_id' => $country->random()->id,
                'birth_date' => '1995-05-15',
                'gender' => 'female',
                'phone' => '0500000002',
                'ide' => 'ID002',
            ],
        ]);
    }
}

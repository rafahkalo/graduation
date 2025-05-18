<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'Hertwdf18*';
        Admin::create([
            'name' => 'maskani',
            'email' => env('ADMIN_EMAIL', 'info@maskani.sa'),
            'password' => Hash::make($password),
        ]);
    }
}

<?php

namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepo
{
    public function getAdminByEmail(string $email): ?Admin
    {
        return Admin::where('email', $email)->first();
    }

    public function isValidAdmin(?Admin $admin, string $password): bool
    {
        return $admin && Hash::check($password, $admin->password);
    }
}

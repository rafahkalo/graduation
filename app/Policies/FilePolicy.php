<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FilePolicy
{
    public function viewAsAdmin(Admin $user, File $file)
    {
        return Auth::guard('api_admin')->check();
    }
}

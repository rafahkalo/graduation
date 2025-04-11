<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class FilePolicy
{

    public function viewAsAdmin(Admin $user, File $file)
    {
        return Auth::guard('api_admin')->check();
    }
}

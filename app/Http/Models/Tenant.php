<?php

namespace App\Http\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tenant extends Authenticatable  implements JWTSubject
{
    use HasUuid, softDeletes;
    protected $fillable = ['first_name', 'last_name', 'national_id', 'birth_date', 'gender', 'phone', 'ide', 'image'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

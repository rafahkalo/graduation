<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Tenant extends Authenticatable implements JWTSubject
{
    use HasUuid, softDeletes;

    protected $fillable = ['first_name', 'last_name', 'national_id', 'birth_date', 'gender', 'phone', 'ide', 'image'];

    protected $hidden = ['image'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function national(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'national_id');
    }
}

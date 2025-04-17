<?php

namespace App\Models;

use App\Traits\HasUuid;
use Carbon\Traits\Units;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasUuid;
    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['code', 'name', 'phone_code', 'translation'];
}

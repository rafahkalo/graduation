<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasUuid, Translatable;

    protected $table = 'countries';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['code', 'name', 'phone_code', 'translation'];
    protected $appends = ['translated'];

    protected $hidden = ['translation', 'created_at', 'updated_at'];
}

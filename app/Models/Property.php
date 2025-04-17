<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Property extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'description1',
        'user_id',
        'translation',
    ];
}

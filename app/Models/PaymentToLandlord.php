<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentToLandlord extends Model
{
    use HasUuids;

    protected $fillable = [
        'admin_id',
        'user_id',
        'financial_transaction_id',
        'approved_by_user',
        'type_transfer',
        'bank_id'
    ];
}

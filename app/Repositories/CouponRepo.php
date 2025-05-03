<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepo extends CoreRepository
{
    public function __construct(Coupon $model)
    {
        parent::__construct($model);
    }
}

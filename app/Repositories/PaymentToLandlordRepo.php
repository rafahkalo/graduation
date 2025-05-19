<?php

namespace App\Repositories;

use App\Models\PaymentToLandlord;

class PaymentToLandlordRepo extends CoreRepository
{

    public function __construct(PaymentToLandlord $model)
    {
        parent::__construct($model);
    }
}

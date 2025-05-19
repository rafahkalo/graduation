<?php

namespace App\Services;

use App\Repositories\PaymentToLandlordRepo;

class PaymentToLandlordService
{

    public function __construct(private PaymentToLandlordRepo $repo)
    {
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }
}

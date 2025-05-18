<?php

namespace App\Repositories;

use App\Models\Offer;

class OfferRepo extends CoreRepository
{
    public function __construct(Offer $model)
    {
        parent::__construct($model);
    }
}

<?php

namespace App\Repositories;

use App\Models\BusinessReview;

class BusinessReviewRepo extends CoreRepository
{
    public function __construct(BusinessReview $model)
    {
        parent::__construct($model);
    }
}

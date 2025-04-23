<?php

namespace App\Repositories;

use App\Models\BusinessReview;
use Illuminate\Support\Facades\Auth;

class BusinessReviewRepo extends CoreRepository
{
    public function __construct(BusinessReview $model)
    {
        parent::__construct($model);
    }
}

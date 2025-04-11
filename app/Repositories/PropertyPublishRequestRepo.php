<?php

namespace App\Repositories;

use App\Models\PropertyPublishRequest;

class PropertyPublishRequestRepo extends CoreRepository
{

    public function __construct(PropertyPublishRequest $request)
    {
        parent::__construct($request);
    }
}

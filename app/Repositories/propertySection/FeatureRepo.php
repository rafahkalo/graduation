<?php

namespace App\Repositories\propertySection;

use App\Models\Feature;
use App\Repositories\CoreRepository;

class FeatureRepo extends CoreRepository
{
    public function __construct(Feature $feature)
    {
        parent::__construct($feature);
    }
}

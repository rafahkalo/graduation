<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepo extends CoreRepository
{
    public function __construct(Location $location)
    {
        parent::__construct($location);
    }

    public function storeLocation(array $location, $modelId = null, $modelType = null)
    {
        return Location::updateOrCreate(
            [
                'model_id' => $modelId,
                'model_type' => $modelType,
            ],
            [
                'lng' => $location['lng'] ?? null,
                'lat' => $location['lat'] ?? null,
                'city' => $location['city'] ?? null,
                'street' => $location['street'] ?? null,
                'direction_id' => $location['direction_id'] ?? null,
            ]
        );
    }
}

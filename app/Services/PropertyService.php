<?php

namespace App\Services;

use App\Models\Feature;
use App\Models\Property;
use App\Models\UnitFeatures;
use App\Repositories\LocationRepo;
use App\Repositories\PropertyRepo;
use App\Repositories\propertySection\UnitFeaturesRepo;
use App\Traits\Media;

class PropertyService
{
    use Media;

    public function __construct(
        private PropertyRepo $propertyRepo,
        private LocationRepo $locationRepo,
        private UnitService $unitService,
        private UnitFeaturesRepo $unitFeaturesRepo,
        /*
        private UnitServiceRepo $unitServiceRepo,

        private MainItemRepo $mainItemRepo
       */
    ) {
    }

    public function store(array $data): null|array
    {
        $response = [];
        $requiredKeys = ['description1', 'name', 'location', 'property_id'];

        if (!empty(array_intersect_key(array_flip($requiredKeys), $data))) {
            $property = $this->propertyRepo->storeProperty($data);
            $data['property_id'] = $property->id ?? $data['property_id'];

            if (array_key_exists('location', $data)) {
                $modelType = Property::class;
                $this->locationRepo->storeLocation($data['location'], $data['property_id'], $modelType);
            }
            $response['property'] = $property;
        }

        if (isset($data['unit_id']) || isset($data['title'])) {

            if (isset($data['main_image'])){
             $data['main_image'] = $this->saveImage($data['main_image'], 'units');
            }

            $unit = $this->unitService->storeUnit($data);

            if (isset($data['features'])) {
                $this->unitFeaturesRepo->updateOrCreateDataOfUnit($data['features'], $unit->id, Feature::class, UnitFeatures::class, 'feature_id');
            }

            if (array_key_exists('images', $data)) {
                $this->saveImages($data['images'], $unit,'units');
            }

            $response['unit'] = $unit ?? [];
        }

        return $response;
    }
}

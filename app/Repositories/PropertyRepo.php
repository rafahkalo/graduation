<?php

namespace App\Repositories;

use App\Models\Property;

class PropertyRepo extends CoreRepository
{
    public function __construct(
        Property $property,
    ) {
        parent::__construct($property);
    }

    public function storeProperty(array $data)
    {
        if (!isset($data['property_id'])) {
            return $this->create($data);
        } else {
            return $this->update($data, $data['property_id']);
        }
    }
}

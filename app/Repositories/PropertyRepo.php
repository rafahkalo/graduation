<?php

namespace App\Repositories;

use App\Models\Property;
use Spatie\QueryBuilder\QueryBuilder;
class PropertyRepo extends CoreRepository
{
    public function __construct(
        Property $property,
    ) {
        parent::__construct($property);
    }

    public function storeProperty(array $data)
    {
        if (! isset($data['property_id'])) {
            return $this->create($data);
        } else {
            return $this->update($data, $data['property_id']);
        }
    }

    public function filterProperties(int $per_page)
    {
        return QueryBuilder::for(Property::class)
            ->allowedFilters(['name', 'description1', 'user_id'])
            ->allowedSorts('created_at', 'desc')
            ->allowedIncludes('user', 'units')
            ->paginate($per_page);
    }
}

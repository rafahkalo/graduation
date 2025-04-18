<?php

namespace App\Repositories;

use App\Filters\MultiColumnSearchFilter;
use App\Models\Country;
use App\Models\Property;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
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

        public function filterCountries(int $per_page): LengthAwarePaginator
    {
        return QueryBuilder::for(Property::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new MultiColumnSearchFilter([
                    'translation'
                ])),
            ])
            ->allowedSorts(['created_at'])
            ->paginate($per_page);
    }
}

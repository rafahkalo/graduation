<?php

namespace App\Repositories;

use App\Filters\LocationRangeFilter;
use App\Filters\MultiColumnSearchFilter;
use App\Models\Property;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
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
        if (!isset($data['property_id'])) {
            return $this->create($data);
        } else {
            return $this->update($data, $data['property_id']);
        }
    }

    public function filterProperties(int $per_page): LengthAwarePaginator
    {
        $featureId = request('featureId') ?? null;
        $categoryId = request('categoryId') ?? null;
        $city = request('city') ?? null;

        $query = QueryBuilder::for(Property::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new MultiColumnSearchFilter([
                    'translation',
                ])),

                AllowedFilter::custom('location_range', new LocationRangeFilter()),
            ])
            ->allowedSorts(['created_at'])
            ->allowedIncludes('units.images', 'units.features', 'units.category', 'location', 'user');

        if (Auth::guard('api_admin')->check()) {
            return $query->paginate($per_page);
        }

        if (Auth::guard('api')->check()) {
            $query->where('user_id', Auth::id());
        } elseif (Auth::guard('api_tenant')->check()) {
            $query->whereHas('units', function ($q) {
                $q->where('status', 'active');
            });
        } else {
            $query->whereHas('units', function ($q) {
                $q->where('status', 'active');
            });
        }

        if ($featureId) {
            $query->hasFeatureInUnit($featureId);
        }

        if ($city) {
            $query->hasLocation($city);
        }

        if ($categoryId) {
            $query->hasCategoryInUnit($categoryId);
        }

        return $query->paginate($per_page);
    }
}

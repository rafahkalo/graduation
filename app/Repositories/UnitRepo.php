<?php

namespace App\Repositories;

use App\Filters\LocationRangeFilter;
use App\Filters\MultiColumnSearchFilter;
use App\Models\Unit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UnitRepo extends CoreRepository
{
    public function __construct(Unit $unit)
    {
        parent::__construct($unit);
    }

    public function filterUnits(int $per_page): LengthAwarePaginator
    {
        $featureId = request('featureId') ?? null;
        $categoryId = request('categoryId') ?? null;
        $query = QueryBuilder::for(Unit::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new MultiColumnSearchFilter([
                    'translation',
                ])),

                AllowedFilter::custom('location_range', new LocationRangeFilter()),
            ])
            ->allowedSorts(['created_at'])
            ->allowedIncludes('images', 'features', 'category', 'property.location', 'user');

        if (Auth::guard('api_admin')->check()) {
            return $query->paginate($per_page);
        }

        if (Auth::guard('api')->check()) {
            $query->where('user_id', Auth::id());
        } elseif (Auth::guard('api_tenant')->check()) {
            $query->where('status', 'active');

        } else {
            $query->where('status', 'active');
        }

        if ($featureId) {
            $query->hasFeatureInUnit($featureId);
        }

        if ($categoryId) {
            $query->hasCategoryInUnit($categoryId);
        }

        return $query->paginate($per_page);
    }
}

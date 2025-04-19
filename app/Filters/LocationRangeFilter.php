<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\Filters\Filter;

class LocationRangeFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $latMin = Arr::get($value, 'lat_min');
        $latMax = Arr::get($value, 'lat_max');
        $lngMin = Arr::get($value, 'lng_min');
        $lngMax = Arr::get($value, 'lng_max');

        $query->whereHas('location', function ($q) use ($latMin, $latMax, $lngMin, $lngMax) {
            if ($latMin !== null && $latMax !== null) {
                $q->whereBetween('lat', [$latMin, $latMax]);
            }

            if ($lngMin !== null && $lngMax !== null) {
                $q->whereBetween('lng', [$lngMin, $lngMax]);
            }
        });

        return $query;
    }
}

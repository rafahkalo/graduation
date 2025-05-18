<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\Filters\Filter;

class FeatureNameFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $result = $query->whereHas('units.features', function ($q) use ($value) {
            $q->where('unit_id', $value);
        });

        Log::info('Query Result:', [
            'value' => $value,
            'property' => $property,
            'sql_query' => $result->toSql(),
            'bindings' => $result->getBindings(),
        ]);

        return $result;
    }
}

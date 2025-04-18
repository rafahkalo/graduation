<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MultiColumnSearchFilter implements Filter
{
    protected array $columns = [];

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query->where(function ($query) use ($value) {
            foreach ($this->columns as $column) {
                $query->orWhere($column, 'LIKE', "%{$value}%");
            }
        });
    }
}

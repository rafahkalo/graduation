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
        $locale = request()->header('lang', app()->getLocale());

        return $query->where(function ($query) use ($value, $locale) {
            foreach ($this->columns as $column) {
                if (in_array($column, ['name'])) {
                    $jsonPath = "$.{$locale}.{$column}";
                    $query->orWhereRaw('JSON_UNQUOTE(JSON_EXTRACT(translation, ?)) LIKE ?', [$jsonPath, "%{$value}%"]);
                }
                // إذا كان عمود نص ترجمة مباشر
                elseif ($column === 'translation') {
                    $jsonPath = "$.{$locale}";
                    $query->orWhereRaw('JSON_UNQUOTE(JSON_EXTRACT(translation, ?)) LIKE ?', [$jsonPath, "%{$value}%"]);
                } else {
                    $query->orWhere($column, 'LIKE', "%{$value}%");
                }
            }
        });
    }
}

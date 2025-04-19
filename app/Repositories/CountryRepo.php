<?php

namespace App\Repositories;

use App\Filters\MultiColumnSearchFilter;
use App\Models\Country;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CountryRepo
{
    public function filterCountries(int $per_page): LengthAwarePaginator
    {
        return QueryBuilder::for(Country::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new MultiColumnSearchFilter([
                    'code', 'phone_code', 'translation',
                ])),
            ])
            ->allowedSorts(['created_at'])
            ->paginate($per_page);
    }
}

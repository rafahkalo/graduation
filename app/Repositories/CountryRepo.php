<?php

namespace App\Repositories;

use App\Filters\MultiColumnSearchFilter;
use App\Models\Country;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

class CountryRepo
{
    public function filterCountries(int $per_page): LengthAwarePaginator
    {
        return QueryBuilder::for(Country::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new MultiColumnSearchFilter([
                    'name', 'code', 'phone_code',
                ])),
            ])
            ->allowedSorts(['created_at'])
            ->paginate($per_page);
    }
}

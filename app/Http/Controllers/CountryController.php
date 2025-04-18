<?php

namespace App\Http\Controllers;

use App\Repositories\CountryRepo;
use Illuminate\Http\JsonResponse;
class CountryController extends BaseController
{
    public function __construct(private CountryRepo $countryRepo)
    {
    }
    public function index(): JsonResponse
    {
        $result = $this->countryRepo->filterCountries(request()->per_page ?? 8);

        return $this->apiResponse(data: $result);
    }
}

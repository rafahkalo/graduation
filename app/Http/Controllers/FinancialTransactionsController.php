<?php

namespace App\Http\Controllers;

use App\Services\FinancialTransactionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinancialTransactionsController extends BaseController
{
    public function __construct(private FinancialTransactionsService $service)
    {
    }

    public function index(): JsonResponse
    {
        $status = request()->query('status') ?? null;
        $result = $this->service->index(per_page: request()->per_page ?? 8, status: $status);

        return $this->apiResponse(data: $result);
    }
}

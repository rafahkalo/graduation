<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentToLandlordRequest;
use App\Models\FinancialTransaction;
use App\Models\Notification;
use App\Models\PaymentToLandlord;
use App\Services\FinancialTransactionsService;
use Faker\Provider\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use function Illuminate\Events\queueable;

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

    //not finish yet

    public function payment(PaymentToLandlordRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $this->service->handlePaymentToLandlord($validatedData);

        return $this->apiResponse();
    }

    public function confirm(Request $request)
    {
        dd($request);
    }
}

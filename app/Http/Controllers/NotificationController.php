<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{

    public function __construct(private NotificationService $service)
    {
    }

    public function index(): JsonResponse
    {
        $result = $this->service->index(per_page: request()->per_page ?? 8);

        return $this->apiResponse(data: $result);
    }

}

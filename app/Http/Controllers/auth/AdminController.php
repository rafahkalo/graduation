<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;

class AdminController extends BaseController
{
    public function __construct(private AdminService $adminService) {}

    public function loginAsAdmin(AdminLoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->adminService->loginAsAdmin($data);

        if (! $result['status']) {
            return $this->apiResponse(message: $result['message'], statusCode: JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->apiResponse(data: $result['user'], message: $result['message']);
    }
}

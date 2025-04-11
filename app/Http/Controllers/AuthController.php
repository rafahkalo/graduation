<?php

namespace App\Http\Controllers;

use App\Http\Models\Tenant;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\CodeRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $data = $request->validated();

        $userClass = match ($data['user_type']) {
            'tenant' => Tenant::class,
            'business' => User::class,
            default => throw new \InvalidArgumentException('Invalid user type')
        };

        $result = $this->authService->login($data, $userClass);

        if (is_array($result) && isset($result['success']) && !$result['success']) {
            return $this->apiResponse(message: $result['message'], statusCode: JsonResponse::HTTP_TOO_MANY_REQUESTS, file: 'auth');
        }

        return $this->apiResponse(data: $result, message: 'login_success');
    }

    public function getVerificationCode(Request $request): JsonResponse
    {
        $result = $this->authService->getVerificationCode($request->input('phone'));

        return $this->apiResponse(data: $result);
    }

    public function checkCode(CodeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_type'] = $request->user_type;
        $result = $this->authService->checkCode($data);

        if (!$result['status']) {
            return $this->apiResponse(message: $result['message'], statusCode: JsonResponse::HTTP_UNAUTHORIZED, file: 'auth');
        }

        return $this->apiResponse(data: $result['data']);
    }
}

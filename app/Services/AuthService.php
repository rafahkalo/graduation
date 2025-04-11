<?php

namespace App\Services;

use App\Http\Models\Tenant;
use App\Models\User;
use App\Repositories\AuthRepo;
use App\Traits\AuthTrait;
use Random\RandomException;

class AuthService
{
    use AuthTrait;

    public function __construct(private AuthRepo $authRepository)
    {
    }

    /**
     * @throws RandomException
     */
    public function login(array $data, string $model)
    {
        // التحقق أولًا: هل يمكن إرسال كود تحقق لهذا الرقم اليوم؟
        if (!$this->authRepository->canSendVerificationCode($data['phone'])) {
            return [
                'success' => false,
                'message' => __('verification_code_limit_exceeded', [], app()->getLocale()),
                ];
        }

        // إنشاء أو استرجاع المستخدم
        $user = $this->authRepository->createOrRestoreUser($data['phone'], $model);

        // توليد كود تحقق جديد بعد التحقق من العدد المسموح
        $this->authRepository->generateVerificationCode($data['phone']);

        return $user;
    }

    public function getVerificationCode(string $phone)
    {
        return $this->authRepository->getVerificationCode($phone);
    }

    public function checkCode(array $data): array
    {
        $user = null;
        $verificationCode = $this->authRepository->getVerificationCode($data['phone']);

        if (!$this->authRepository->isCodeValid($verificationCode, $data['code'])) {
            return [
                 'status' => false,
                 'message' => __('please_request_the_code_again', [], app()->getLocale()),
             ];
        }

        if ($data['user_type'] === 'business') {
            $user = $this->authRepository->getUserByPhone($data['phone'], User::class);
        }
        if ($data['user_type'] === 'tenant') {
            $user = $this->authRepository->getUserByPhone($data['phone'], Tenant::class);
        }

        $token = $this->createTokenForUser($user);
        if (!$token) {
            return [
                'status' => false,
                'message' => __('unauthorized', [], app()->getLocale()),
            ];
        }

        $this->authRepository->deleteVerificationCode($data['phone']);

        return [
            'status' => true,
            'message' => __('logged_in_successfully', [], app()->getLocale()),
            'data' => $this->userWithToken($user, $token),
        ];
    }
}

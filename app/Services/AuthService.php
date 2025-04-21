<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;
use App\Repositories\AuthRepo;
use App\Traits\AuthTrait;
use App\Traits\Media;
use Illuminate\Support\Facades\Auth;
use Random\RandomException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    use AuthTrait, Media;

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

    public function updateProfile(array $data, string $model, $id = null)
    {
        $user = $model::where('id', $id ?? Auth::id())->first();

        if (isset($data['image'])) {
            $this->deleteImage($user->image);
            $data['image'] = $this->saveImage($data['image'], 'profile');
        }

        return $model::where('id', $id ?? Auth::id())->update($data);
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

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());

    }
        public function profile()
    {
        return JWTAuth::parseToken()->authenticate();
    }
}

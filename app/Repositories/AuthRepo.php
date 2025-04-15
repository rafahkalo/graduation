<?php

namespace App\Repositories;

use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Log;
use Random\RandomException;

class AuthRepo
{
    /**
     * حذف رمز التحقق بناءً على رقم الهاتف أو الكائن.
     *
     * @param string|VerificationCode $verificationCode
     * @return void
     */
    public function deleteVerificationCode($verificationCode): void
    {
        if (is_string($verificationCode)) {
            VerificationCode::where('phone', $verificationCode)->delete();
        } else {
            $verificationCode->delete();
        }
    }

    /**
     * إنشاء مستخدم جديد أو استعادة مستخدم محذوف.
     *
     * @param string $phone
     * @param string $model
     * @return Model|Builder
     */
    public function createOrRestoreUser(string $phone, string $model): Model|Builder
    {
        $user = $model::withTrashed()->firstOrNew(['phone' => $phone]);
        $user->save();

        return $user;
    }

    /**
     * إنشاء رمز تحقق جديد.
     *
     * @param string $phone
     * @return void
     * @throws RandomException
     */
    public function generateVerificationCode(string $phone): void
    {
        VerificationCode::create([
           'code' => $this->generateUniqueCode(),
           'phone' => $phone,
        ]);
    }

    /**
     * توليد رمز تحقق.
     *
     * @param int $length
     * @return string
     * @throws RandomException
     */
    public function generateUniqueCode(int $length = 4): string
    {
        do {
            $code = str_pad(random_int(0, 9999), $length, '0', STR_PAD_LEFT); // مثلاً: "0231"
        } while (VerificationCode::where('code', $code)->exists());

        return $code;
    }

    public function canSendVerificationCode(string $phone, int $maxPerDay = 5): bool
    {
        $today = Carbon::today();

        $count = VerificationCode::where('phone', $phone)
            ->whereDate('created_at', $today)
            ->count();
        Log::info("Count for {$phone} today: " . $count);

        return $count < $maxPerDay;
    }

    public function getVerificationCode(string $phone)
    {
        $record = VerificationCode::where('phone', $phone)
            ->orderByDesc('created_at')
            ->first();

        return $record?->code;
    }

    /**
     * التحقق من صحة الرمز المدخل.
     *
     * @param string|null $verificationCode
     * @param string $inputCode
     * @return bool
     */
    public function isCodeValid(?string $verificationCode, string $inputCode): bool
    {
        return $verificationCode && $verificationCode == $inputCode;
    }

    public function getUserByPhone(string $phone, string $model): ?Model
    {
        return $model::where('phone', $phone)->first();
    }
}

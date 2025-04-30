<?php

namespace App\Rules;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CouponValid implements Rule
{
    protected $coupon;
    protected $errorMessages = [];

    public function passes($attribute, $value)
    {
        // البحث عن الكوبون في قاعدة البيانات
        $this->coupon = Coupon::where('code', $value)->first();

        // تحقق مما إذا كان الكوبون موجودًا
        if (!$this->coupon) {
            $this->errorMessages[] = $this->getMessage('coupon_not_found');
            return false; // الكوبون غير موجود
        }

        // تحقق من حالة الكوبون
        if ($this->coupon->status !== 'active') {
            $this->errorMessages[] = $this->getMessage('coupon_inactive');
            return false; // الكوبون غير نشط
        }

        // تحقق من تاريخ البدء والانتهاء
        $now = Carbon::now();
        if ($this->coupon->starts_at > $now) {
            $this->errorMessages[] = $this->getMessage('coupon_not_started');
            return false; // الكوبون لم يبدأ بعد
        }

        if ($this->coupon->expires_at < $now) {
            $this->errorMessages[] = $this->getMessage('coupon_expired');
            return false; // الكوبون قد انتهت صلاحيته
        }

        // تحقق من الحد الأقصى للاستخدامات
        if ($this->coupon->max_uses && $this->coupon->current_uses >= $this->coupon->max_uses) {
            $this->errorMessages[] = $this->getMessage('coupon_max_uses');
            return false; // تم استخدام الكوبون الحد الأقصى
        }

        // تحقق من الحد الأقصى للاستخدامات لكل مستخدم
    /*    if ($this->coupon->max_uses_per_user) {
            $userUses = $this->coupon->uses()->where('user_id', auth()->id())->count();
            if ($userUses >= $this->coupon->max_uses_per_user) {
                $this->errorMessages[] = $this->getMessage('coupon_user_max_uses');
                return false; // تم استخدام الكوبون من قبل المستخدم الحد الأقصى
            }
        }
*/
        return true; // الكوبون صالح
    }

    protected function getMessage($key)
    {
        // استخدام الترجمة من ملفات اللغة
        return trans("validation.$key");
    }

    public function message()
    {
        return implode(' ', $this->errorMessages);
    }
}

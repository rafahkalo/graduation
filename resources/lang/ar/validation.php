<?php

return [
    'required' => 'حقل :attribute مطلوب.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح.',
    'min' => [
        'string' => 'يجب أن يكون :attribute على الأقل :min أحرف.',
    ],
    'confirmed' => 'تأكيد :attribute غير مطابق.',
    'password' => [
        'min' => 'يجب أن تكون كلمة المرور على الأقل :min أحرف.',
        'regex' => 'يجب أن تحتوي كلمة المرور على الأقل على حرف كبير، حرف صغير، رقم، ورمز خاص.',
        'strong' => 'كلمة المرور ضعيفة جدًا.',
    ],
    'attributes' => [
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
    ],
    'saudi_phone_invalid' => 'شروط الرقم غير صحيحة',

    'status_change_not_allowed' => 'لا يمكنك تغيير الحالة إلى "جاري الانتظار" بعد أن تم رفض الطلب.',
    'status_updated_success' => 'تم تحديث الحالة بنجاح.',
    'coupon_not_found' => 'الكوبون غير موجود.',
    'coupon_inactive' => 'الكوبون غير نشط.',
    'coupon_not_started' => 'الكوبون لم يبدأ بعد.',
    'coupon_expired' => 'الكوبون قد انتهت صلاحيته.',
    'coupon_max_uses' => 'تم استخدام الكوبون الحد الأقصى.',
    'coupon_user_max_uses' => 'تم استخدام الكوبون من قبل المستخدم الحد الأقصى.',
    'custom' => [
        'people_count' => [
            'exceeds_unit_limit' => 'عدد الأشخاص المدخل أكبر من الحد الأقصى المسموح به للوحدة.',
        ]
    ],
];

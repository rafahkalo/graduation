<?php

namespace App\Http\Requests;

use App\Models\PropertyPublishRequest;
use App\Rules\UserOwnsModel;

class PropertyPublishRequestRequest extends BaseRequest
{
    public function rules()
    {
        return $this->isMethod('POST') ? $this->store() : $this->update();
    }

    protected function store(): array
    {
        return [
            'property_type' => 'required|in:apartment,villa,house,land,commercial,other',
            'files.*' => 'required|file',
        ];
    }

    protected function update(): array
    {
        $rules = [
            'property_approval_request' => [
                'required',
                'exists:property_publish_requests,id',
            ],
        ];

        if (auth()->guard('api_admin')->check()) {
            // فقط الادمن يقدر يعدل status و reason
            $rules['status'] = 'required|in:pending,approved,rejected';
            $rules['reason'] = 'nullable|string';
        } else {
            // فقط المؤجر يقدر يعدل باقي الحقول
            $rules['notes'] = 'nullable|string';
            $rules['property_type'] = 'required|in:apartment,villa,house,land,commercial,other';
            $rules['property_approval_request'][] = new UserOwnsModel(PropertyPublishRequest::class);
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $approvalRequestId = $this->route('property_approval_request') ?? $this->input('property_approval_request');

            if (!$approvalRequestId) {
                return; // ID غير موجود في البيانات المرسلة
            }

            $approvalRequest = PropertyPublishRequest::find($approvalRequestId);

            if (!$approvalRequest) {
                return; // القاعدة exists ستتعامل مع هذا
            }

            // إذا كانت الحالة مرفوضة، لا يمكن تعديلها إلى جاري الانتظار
            if (
                $approvalRequest->status === 'rejected' &&
                $this->input('status') === 'pending'
            ) {
                $validator->errors()->add('status', trans('validation.status_change_not_allowed'));
            }
        });
    }
}

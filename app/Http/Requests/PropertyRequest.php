<?php

namespace App\Http\Requests;

use App\Models\Property;
use App\Models\Unit;
use App\Rules\SaudiPhoneRule;
use App\Rules\UserOwnsModel;
use Illuminate\Support\Facades\Auth;

class PropertyRequest extends BaseRequest
{
    public function rules()
    {
        return $this->isMethod('POST') ? $this->store() : $this->update();
    }

    protected function store(): array
    {
        return [
            'name' => 'sometimes',
            'description1' => 'sometimes',
            'user_id' => 'required',
            'title' => 'nullable|string|max:255',
            'description2' => 'sometimes',
            'type' => 'nullable|in:licensed,marketing',
            'advertiser_type' => 'nullable|in:owner,agent,marketer',
            'street_width' => 'nullable|integer|min:0|max:100',
            'space' => 'nullable|numeric|min:0',
            'num_person' => 'required|numeric|min:0',
            'unit_id' => [
                'sometimes',
                'exists:units,id',
                new UserOwnsModel(Unit::class),
            ],
            'equipment' => 'nullable|in:furnished,unfurnished',
            'property_type' => 'nullable|in:commercial_and_residential,commercial,residential',
            'reservation_type' => 'nullable|in:monthly,yearly',
            'deposit' => 'nullable|integer|min:0',
            'floor' => 'nullable|integer|min:0',
            'property_age' => 'nullable|integer|min:0',
            'house_rules' => 'nullable|string',
            'status' => 'sometimes|in:inactive,active',
            'price' => 'nullable|numeric|min:0',
            'property_id' => [
                'sometimes',
                'uuid',
                'exists:properties,id',
                new UserOwnsModel(Property::class),
            ],
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'category_id' => 'nullable|exists:categories,id',
            'guard_name' => 'sometimes',
            'video' => 'sometimes',
            'features' => 'nullable|array',
            'guard_phone' => ['nullable', new SaudiPhoneRule],
            'location' => 'sometimes|array',
            'images' => 'sometimes|array',
        ];
    }

    protected function update(): array
    {
        $rules = [
            'property' => [
                'required',
                'exists:properties,id',
            ],
            'name' => 'sometimes',
            'description1' => 'sometimes',
            'location' => 'sometimes|array',
        ];

        if (!$this->isAdminRequest()) {
            $rules['property'][] = new UserOwnsModel(Property::class);
        }

        return $rules;
    }

    /**
     * التحقق مما إذا كان الطلب من مسؤول (api_admin).
     */
    protected function isAdminRequest(): bool
    {
        return in_array('auth:api_admin', request()->route()->middleware());
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::id(),
            'guard_phone' => $this->guard_phone ? SaudiPhoneRule::formatSaudiPhone($this->guard_phone) : $this->phone,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $price = $this->input('price');
            $deposit = $this->input('deposit');

            if (!is_null($price) && !is_null($deposit) && $deposit >= $price) {
                $validator->errors()->add('deposit', 'The deposit must be less than the price.');
            }
        });
    }
}

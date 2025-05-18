<?php

namespace App\Http\Requests;

use App\Models\Offer;
use App\Models\Unit;
use App\Rules\UserOwnsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class OfferRequest extends BaseRequest
{
    public function rules(): array
    {
        return $this->isMethod('POST') ? $this->store() : ($this->isMethod('DELETE') ? $this->destroy() : $this->update());
    }

    public function store(): array
    {
        return [
            'name' => 'required|string|max:255',
            'num_usage' => 'nullable|integer|min:0',
            'type_offer' => 'required|in:fixed,percent',
            'value_offer' => 'required|integer|min:0',
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'user_id' => 'required|exists:users,id',
            'unit_id' => [
                'required',
                'exists:units,id',
                new UserOwnsModel(Unit::class)],
        ];
    }

    public function update(): array
    {
        return [
            'offer' => [
                'required',
                'exists:offers,id',
                new UserOwnsModel(Offer::class),

            ],
            'name' => 'sometimes|string|max:255',
            'num_usage' => 'sometimes|integer|min:0',
            'type_offer' => 'sometimes|in:fixed,percent',
            'value_offer' => 'sometimes|integer|min:0',
            'from' => 'sometimes|date',
            'to' => 'sometimes|date|after_or_equal:from',
            'unit_id' => [
                'sometimes',
                'exists:units,id',
                new UserOwnsModel(Unit::class)],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
    }

    public function destroy(): array
    {
        return [
            'offer' => [
                'required',
                'exists:offers,id',
                new UserOwnsModel(Offer::class),
            ],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $offerId = $this->route('offer');
            $offer = null;

            if (is_string($offerId)) {
                $offer = Offer::where('id', $offerId)
                    ->where('user_id', Auth::id())
                    ->first();
            }

            if ($this->isMethod('DELETE')) {
                if ($offer && $offer->reservations()->exists()) {
                    $validator->errors()->add('offer', __('offer.delete_offer_has_reservations'));
                }
            }

            // حالة POST أو UPDATE: تحقق من وجود الحجوزات
            if (!$this->isMethod('DELETE') && $offer && $offer->reservations()->exists()) {
                $validator->errors()->add('offer', __('offer.delete_offer_has_reservations'));
            }
        });
    }
}

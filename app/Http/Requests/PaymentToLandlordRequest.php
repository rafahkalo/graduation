<?php

namespace App\Http\Requests;


class PaymentToLandlordRequest extends BaseRequest
{
    public function rules()
    {
        return [
          'type_transfer' => 'required|in:bank',
           'bank_id' =>  'required|exists:banks,id',
            'financial_transaction_id'  => 'required|exists:financial_transactions,id',
        ];
    }
}

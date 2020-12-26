<?php

namespace Qihucms\Currency\Requests\CashOutOrder;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currency_type_id' => ['required', 'exists:currency_types,id'],
            'currency_bank_card_id' => ['required', 'exists:currency_bank_cards,id'],
            'cash_out_amount' => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return trans('currency::cash_out_order');
    }
}
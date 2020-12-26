<?php

namespace Qihucms\Currency\Requests\ExchangeOrder;

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
            'currency_exchange_id' => ['required', 'exists:currency_exchanges,id'],
            'exchange_amount' => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return trans('currency::exchange_order');
    }
}
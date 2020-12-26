<?php

namespace Qihucms\Currency\Requests\BankCard;

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
     *sometimes
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:66'],
            'bank' => ['required', 'max:255'],
            'mobile' => ['filled', 'regex:/^1[3456789]{1}\d{9}$/'],
            'account' => ['required', 'max:255']
        ];
    }

    public function attributes()
    {
        return trans('currency::bank_card');
    }
}
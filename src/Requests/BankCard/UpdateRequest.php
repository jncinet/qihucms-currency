<?php

namespace Qihucms\Currency\Requests\BankCard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => ['filled', 'max:66'],
            'bank' => ['filled', 'max:255'],
            'mobile' => ['filled', 'regex:/^1[3456789]{1}\d{9}$/'],
            'account' => ['filled', 'max:255']
        ];
    }

    public function attributes()
    {
        return trans('currency::bank_card');
    }
}
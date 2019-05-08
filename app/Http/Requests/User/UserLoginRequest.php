<?php

namespace App\Http\Requests\User;

use App\Helpers\Helpers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email' => 'required',
            'password' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $validate = new Helpers();
        $validate->failedValidation($validator);
    }

}

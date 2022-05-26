<?php

namespace App\Http\Requests\Auth;

use App\Traits\Auth\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class PasswordConfirmationRequest extends FormRequest
{
    use PasswordValidationRules;

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
            'password' => $this->passwordRules(),
        ];
    }
}

<?php
namespace App\Traits\Auth;

use App\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules(bool $confirmable = null)
    {
        return [
            'required',
            'string',
            new Password,
            $confirmable ?'confirmed': '',
            'min:8'
        ];
    }
}

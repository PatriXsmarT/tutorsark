<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|filled',
            'last_name' => 'required|string|filled',
            'middle_name' => 'nullable|string|filled',
            'gender' => 'required|string|filled',
            'occupation' => 'required|string|filled',
            'dob' => 'required|date|filled',
            'bio' => 'required|string|filled',
            'website' => 'nullable|url|filled',
            'phone_number' => 'required|numeric',
            'address' => 'required|string|filled',
            'town' => 'required|string|filled',
            'state' => 'required|string|filled',
            'country' => 'required|string|filled'
        ];
    }
}

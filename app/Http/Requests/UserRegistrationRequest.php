<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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

    public function rules() : array
    {
        return [
            'name' => ['required', 'min:3', 'max:30'],
            'email' => ['required', 'max:30', 'email'],
            'password' => ['required', 'min:6'],
        ];
    }
}

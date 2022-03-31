<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegistrationRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'max:30', 'email:strict'],
            'password' => ['required', 'min:6'],
            'roles' => ['required', Rule::in(['doctor', 'patient'], 'exists:roles,name')],
        ];
    }
}

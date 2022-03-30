<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

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
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'max:30', 'email:strict'],
            'password' => ['required', 'min:6'],
        ];
    }

    protected function PassedValidation()
    {
        return $this->merge(['password' => Hash::make($this->input('password'))]);
    }
}

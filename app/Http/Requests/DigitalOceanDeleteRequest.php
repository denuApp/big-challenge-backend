<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DigitalOceanDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctorProfileImageFileName' => 'required|string',
        ];
    }
}

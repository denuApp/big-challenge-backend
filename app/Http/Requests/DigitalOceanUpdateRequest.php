<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DigitalOceanUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctorProfileImageFile' => 'required|image|max:2048',
            'doctorProfileImageFileName' => 'required|string',
        ];
    }
}

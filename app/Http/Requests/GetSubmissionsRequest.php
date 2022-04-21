<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetSubmissionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('patient');
    }

    public function rules():array
    {
        return [
            'status' => [Rule::in(['pending', 'in_progress', 'ready'])],
        ];
    }
}

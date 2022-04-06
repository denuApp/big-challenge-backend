<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmissionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('patient');
    }

    public function rules():array
    {
        return [
            'patient_id' => ['required'],
            'symptoms' => ['required', 'max:655535'],
            'status' => [Rule::in(['pending', 'in_progress', 'ready'])],
        ];
    }
}

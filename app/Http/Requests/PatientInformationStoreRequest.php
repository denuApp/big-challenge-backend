<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientInformationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('patient');
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required'],
            'id_number' => ['required'],
            'gender' => ['required', Rule::in(['female', 'male', 'other'])],
            'birth_date' => ['required', 'date'],
            'height' => ['required'],
            'weight' => ['required'],
        ];
    }
}

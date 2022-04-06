<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientInformationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole('patient');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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

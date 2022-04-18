<?php

namespace App\Http\Requests;

use App\Models\PatientInformation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PatientInformationEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var PatientInformation $patientInfo */
        $patientInfo = $this->route('patientInfo');

        return $this->user()->hasRole('patient') && $patientInfo->patient_id == Auth::user()->id;
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

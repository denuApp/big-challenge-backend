<?php

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmissionTakeRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');

        return $this->user()->hasRole('doctor') && ($submission->status == 'pending');
    }

    protected function prepareForValidation()
    {
        $this->merge(['status' => 'in_progress']);
    }

    public function rules():array
    {
        return [
            'doctor_id' => ['required'],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'ready'])],
        ];
    }
}

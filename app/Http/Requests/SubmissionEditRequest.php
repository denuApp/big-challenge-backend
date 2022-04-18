<?php

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SubmissionEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');

        return $this->user()->hasRole('patient') && $submission->patient_id == Auth::user()->id;
    }

    public function rules():array
    {
        return [
            'patient_id' => ['required'],
            'symptoms' => ['required', 'max:655535'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SubmissionDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');
//        return true;
        return $this->user()->hasRole('patient') && $submission->patient_id == Auth::user()->id;
    }

    public function rules():array
    {
        return [
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;

class DigitalOceanStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');

        return $this->user()->hasRole('doctor') && ($submission->doctor_id == $this->user()->id);
    }

    public function rules(): array
    {
        return [
            'prescription' => ['requiered', 'mimetypes:text/plain'],
        ];
    }
}

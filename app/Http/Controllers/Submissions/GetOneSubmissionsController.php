<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubmissionResource;
use App\Models\PatientInformation;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class GetOneSubmissionsController extends Controller
{
    public function __invoke(Submission $submission): SubmissionResource
    {
        $info = PatientInformation::latest()->where('patient_id', Auth::user()->id)->get();

        return new SubmissionResource($submission);
    }
}

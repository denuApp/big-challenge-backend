<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Models\PatientInformation;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetOneSubmissionsController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse
    {
        $info = PatientInformation::latest()->where('patient_id', Auth::user()->id)->get();

        return response()->json([
            'submissions' => $submission,
            'info' => $info,
        ]);
    }
}

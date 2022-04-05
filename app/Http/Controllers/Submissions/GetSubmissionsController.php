<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetSubmissionsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $submissions = Submission::latest()->where('patient_id', Auth::user()->id)->get();

        return response()->json([
            'submissions' => $submissions,
        ]);
//        $submission = Submission::create($request->validated());
//
//        return new SubmissionResource($submission);
    }
}

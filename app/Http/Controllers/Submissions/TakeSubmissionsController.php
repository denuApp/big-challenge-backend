<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionTakeRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;

class TakeSubmissionsController extends Controller
{
    public function __invoke(SubmissionTakeRequest $request, Submission $submission): SubmissionResource
    {
        $submission->update($request->validated());

        return new SubmissionResource($submission);
    }
}

<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionEditRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;

class EditSubmissionsController extends Controller
{
    public function __invoke(SubmissionEditRequest $request, Submission $submission): SubmissionResource
    {
        $submission->update($request->validated());

        return new SubmissionResource($submission);
    }
}

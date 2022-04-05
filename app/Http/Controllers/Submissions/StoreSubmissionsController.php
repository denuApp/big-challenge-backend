<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionStoreRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;

class StoreSubmissionsController extends Controller
{
    public function __invoke(SubmissionStoreRequest $request): SubmissionResource
    {
        $submission = Submission::create($request->validated());

        return new SubmissionResource($submission);
    }
}

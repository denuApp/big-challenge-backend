<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;

class GetOneSubmissionsController extends Controller
{
    public function __invoke(Submission $submission): SubmissionResource
    {
        return new SubmissionResource($submission);
    }
}

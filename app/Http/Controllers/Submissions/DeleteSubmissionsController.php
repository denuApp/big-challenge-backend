<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionDeleteRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class DeleteSubmissionsController extends Controller
{
    public function __invoke(SubmissionDeleteRequest $request, Submission $submission): JsonResponse
    {
        $submission->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Submission deleted successfully!',
        ]);
    }
}

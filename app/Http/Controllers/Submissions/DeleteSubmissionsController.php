<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteSubmissionsController extends Controller
{
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Models\Submission  $submission
//     * @return \Illuminate\Http\Response
//     */
    public function __invoke(Request $submission): JsonResponse
    {
        Submission::destroy($submission->id);

        return response()->json([
            'status' => 200,
            'message' => 'Submission deleted successfully!',
        ]);
    }
}

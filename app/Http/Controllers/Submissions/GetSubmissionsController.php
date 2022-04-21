<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSubmissionsRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetSubmissionsController extends Controller
{
    public function __invoke(GetSubmissionsRequest $request): JsonResponse
    {
        $req = $request->validated();

        $status = ($req ? $req['status'] : null);

        $submissions = Submission::latest()
            ->where('patient_id', Auth::user()->id)
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->get();

        return response()->json([
            'submissions' => $submissions,
        ]);
    }
}

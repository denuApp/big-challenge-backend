<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionStoreRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class StoreSubmissionsController extends Controller
{
    public function __invoke(SubmissionStoreRequest $request): SubmissionResource
    {
        $users = User::all();
        $user = $users->find($request->patient_id);
        if (isset($user) && $user->hasRole('patient')) {
            $submission = Submission::create($request->validated());

            return new SubmissionResource($submission);
        } else {
            throw ValidationException::withMessages([
                'patient_id' => ['The provided credentials are incorrect.'],
            ]);
//            return response()->json(
//                'The provided credentials are incorrect.',
//                '422'
//            );
        }
    }
}

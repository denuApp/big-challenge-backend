<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientInformationStoreRequest;
use App\Http\Resources\PatientInformationResource;
use App\Models\Information;

class PatientInformationController extends Controller
{
    public function __invoke(PatientInformationStoreRequest $request): PatientInformationResource
    {
        $information = Information::create($request->validated());

        return new PatientInformationResource($information);
    }
}

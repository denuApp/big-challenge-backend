<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientInformationEditRequest;
use App\Http\Resources\PatientInformationResource;
use App\Models\PatientInformation;

class EditPatientInformationController extends Controller
{
    public function __invoke(PatientInformationEditRequest $request, PatientInformation $patientInfo): PatientInformationResource
    {
        $patientInfo->update($request->validated());

        return new PatientInformationResource($patientInfo);
    }
}

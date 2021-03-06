<?php

namespace App\Http\Resources;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Submission
 */
class SubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $patient = User::where('id', $this->patient_id)->first();

        return[
            'id' => $this->id,
            'patient' => ($this->patient_id) ? new UserResource($patient->load('patientInformation')) : null,
            'doctor_id' => $this->doctor_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'symptoms' => $this->symptoms,
            'prescription' => $this->prescription,
        ];
    }
}

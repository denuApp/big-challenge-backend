<?php

namespace App\Http\Resources;

use App\Models\PatientInformation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PatientInformation
 */
class PatientInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'user_id' => $this->patient_id,
            'id_number' => $this->id_number,
            'gender' => $this->gender,
            'birth_date' =>$this->birth_date,
            'height' => $this->height,
            'weight' => $this->weight,
        ];
    }
}

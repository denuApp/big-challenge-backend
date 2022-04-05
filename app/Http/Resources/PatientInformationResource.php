<?php

namespace App\Http\Resources;

use App\Models\Information;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Information
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
            'patient_id' => $this->patient_id,
            'id_number' => $this->id_number,
            'gender' => $this->gender,
            'birth_date' =>$this->birth_date,
            'height' => $this->height,
            'weight' => $this->weight,
        ];
    }
}

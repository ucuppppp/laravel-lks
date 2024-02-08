<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "status" => $this->status,
            "disease_history" => $this->disease_history,
            "current_symptoms" => $this->current_symptoms,
            "doctor_notes" => $this->doctor_notes,
            "doctor" => $this->medical
        ];
    }
}

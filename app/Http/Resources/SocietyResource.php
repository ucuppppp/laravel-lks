<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocietyResource extends JsonResource
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
            "name" => $this->name,
            "born_date" => $this->born_date,
            "gender" => $this->gender,
            "address" => $this->address,
            "token" => $this->login_tokens,
            "regional" => $this->whenLoaded('regional')
        ];
    }
}

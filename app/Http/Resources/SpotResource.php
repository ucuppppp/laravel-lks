<?php

namespace App\Http\Resources;

use App\Models\Vaccine;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $spot_vaccines_ids = $this->spot_vaccines->pluck('vaccine_id')->toArray();

        $vaccines = Vaccine::all();

        $data = [];

        foreach($vaccines as $vaccine){
            $data[$vaccine->name] = in_array($vaccine->id, $spot_vaccines_ids);
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "address" => $this->address,
            "serve" => $this->serve,
            "capacity" => $this->capacity,
            "available_vaccines" => $data
        ];
    }
}

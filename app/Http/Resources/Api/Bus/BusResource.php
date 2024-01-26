<?php

namespace App\Http\Resources\Api\Bus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "vehicle_no" => $this->vehicle_no,
            "route_id" => $this->route_id,
            "from_time" => $this->from_time,
            "to_time" => $this->to_time,
            "status" => $this->status,
        ];
    }
}

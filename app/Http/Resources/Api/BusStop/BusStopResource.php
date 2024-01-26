<?php

namespace App\Http\Resources\Api\BusStop;

use App\Http\Resources\Api\Route\RouteResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusStopResource extends JsonResource
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
            // "route_id" => $this->route_id,
            "name" => $this->name,
            "slug" => $this->slug,
            "location" => $this->location,
            "longitude" => $this->longitude,
            "latitude" => $this->latitude,
            "status" => $this->status,

        ];
    }
}

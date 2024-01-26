<?php

namespace App\Http\Resources\Api\Route;

use App\Http\Resources\Api\Bus\BusResource;
use App\Http\Resources\Api\BusStop\BusStopResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteWiseBusStopResource extends JsonResource
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
            "slug" => $this->slug,
            "status" => $this->status,
            "busStop" => new BusStopResource($this->getBusStop),

        ];
    }
}

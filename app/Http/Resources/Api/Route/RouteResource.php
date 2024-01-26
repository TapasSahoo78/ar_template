<?php

namespace App\Http\Resources\Api\Route;

use App\Http\Resources\Api\BusStop\BusStopResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "status" => $this->status,
            // "busStop" => $this->getBusStop,
            "busStop" =>  BusStopResource::collection($this->getBusStop),
        ];
    }
}

<?php

namespace App\Http\Resources\Api\Driver;

use App\Http\Resources\Api\Bus\BusResource;
use App\Http\Resources\Api\Route\RouteResource;
use App\Http\Resources\Api\User\UserProfileResource;
use App\Http\Resources\Api\User\UserResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'route_id' => new RouteResource($this->getBus->getRoute),
            'bus_id' => $this->bus_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'bus' => new BusResource($this->getBus),
            'user' =>  new UserProfileResource($this->getUser),
            // 'route' => new RouteResource($this->getBus->getRoute),
        ];
    }
}

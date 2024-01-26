<?php

namespace App\Http\Resources\Api\Booking;

use App\Http\Resources\Api\BusStop\BusStopResource;
use App\Http\Resources\Api\Bus\BusResource;
use App\Http\Resources\Api\Route\RouteResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            "user_id" => $this->user_id,
            "bus" => new BusResource($this->bus),
            "route" =>  new RouteResource($this->busRout),
            "bookingBusStop" =>  new BusStopResource($this->busStop),
            "longitude" => $this->longitude,
            "latitude" => $this->latitude,
            "date" => $this->date,
            "time" => $this->time,
            "booking_no" => $this->booking_no,
            "is_validate" => $this->is_validate,
            "status" => $this->status,
        ];
    }
}

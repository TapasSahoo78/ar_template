<?php

namespace App\Http\Resources\Api\User;

use App\Http\Resources\Api\Auth\CityApiCollection;
use App\Http\Resources\Api\Auth\CountryApiCollection;
use App\Http\Resources\Api\Auth\StateApiCollection;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationInformationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        $country = Country::find($this->country);
        $state = State::find($this->state);
        $city = City::find($this->city);
        return [
            'country' => new CountryApiCollection($country),
            'state' => new StateApiCollection($state),
            'city' => new CityApiCollection($city),
            'citizenship' => $this->citizenship,
            'ancestral_origin' => $this->ancestral_origin,
        ];
    }
}

<?php

namespace App\Http\Resources\Api\User;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Auth\CityApiCollection;
use App\Http\Resources\Api\Auth\StateApiCollection;
use App\Http\Resources\Api\Auth\CountryApiCollection;
use App\Http\Resources\Api\User\BasicInformationCollection;

class UserPreferenceCollection extends JsonResource
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
            'id' => $this->id ?? '',
            'age' => $this->age ?? '',
            'height' => $this->height ?? '',
            'marital_status' => $this->marital_status ?? '',
            'mother_tongue' => $this->mother_tongue ?? '',
            'physical_status' => $this->physical_status ?? '',
            'eating_habits' => $this->eating_habits ?? '',
            'smoking_habits' => $this->smoking_habits ?? '',
            'drinking_habits' => $this->drinking_habits ?? '',
            'religion' => $this->religion ?? '',
            'community' => $this->community ?? '',
            'caste' => $this->caste ?? '',
            'star' => $this->star ?? '',
            'dosh' => $this->dosh ?? '',
            'education_category' => $this->education_category ?? '',
            'employed_in' => $this->employed_in ?? '',
            'occupation' => $this->occupation ?? '',
            'annual_income' => $this->annual_income ?? '',
            'country' => new CountryApiCollection($country),
            'state' => new StateApiCollection($state),
            'city' => new CityApiCollection($city),
            'special_preference' => $this->special_preference ?? ''
        ];
    }
}

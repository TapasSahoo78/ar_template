<?php

namespace App\Http\Resources\Api\User;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchedProfileCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        $profile_pic = asset('storage/no-image.png');
        if(!empty($this->profile_photo)) {
            $profile_pic = asset('storage/user_images') .'/'. $this->profile_photo;
        }

        $country = Country::find($this->getLocation?->country);
        $state = State::find($this->getLocation?->state);
        $city = City::find($this->getLocation?->city);

        return [
            'id' => $this->id,
            'first_name' => $this->first_name ?? '',
            'last_name' => $this->last_name ?? '',
            'age' => $this->age ?? '',
            'dob' => $this->dob ?? '',
            'about_me' => $this->about_me ?? '',
            'profile_photo' => $profile_pic ?? '',
            'profile_type' => $this->profile_type ?? '',
            'height' => $this->getProfileBasicDetails?->height ?? '',
            'religion' => $this->religion ?? '',
            'community' => $this->community ?? '',
            'caste' => $this->getReligiousInformation?->caste ?? '',
            'gotra' => $this->getReligiousInformation?->gotra ?? '',
            'zodiac' => $this->getReligiousInformation?->zodiac ?? '',
            'country' => $country?->name ?? '',
            'state' => $state?->name ?? '',
            'city' => $city?->name ?? '',
            'user_documents'=> new UserDocumentCollection($this->getDocuments),
        ];
    }
}

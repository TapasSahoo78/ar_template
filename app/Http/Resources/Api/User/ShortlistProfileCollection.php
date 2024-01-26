<?php

namespace App\Http\Resources\Api\User;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortlistProfileCollection extends JsonResource
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

        $country = Country::find($this->getShortlistUser?->getLocation?->country);
        $state = State::find($this->getShortlistUser?->getLocation?->state);
        $city = City::find($this->getShortlistUser?->getLocation?->city);

        return [
            'id' => $this->id,
            'user_id' => $this->getShortlistUser?->id,
            'first_name' => $this->getShortlistUser?->first_name ?? '',
            'last_name' => $this->getShortlistUser?->last_name ?? '',
            'age' => $this->getShortlistUser?->age ?? '',
            'dob' => $this->getShortlistUser?->dob ?? '',
            'about_me' => $this->getShortlistUser?->about_me ?? '',
            'profile_photo' => $profile_pic ?? '',
            'profile_type' => $this->getShortlistUser?->profile_type ?? '',
            'height' => $this->getShortlistUser?->getProfileBasicDetails?->height ?? '',
            'religion' => $this->getShortlistUser?->religion ?? '',
            'community' => $this->getShortlistUser?->community ?? '',
            'caste' => $this->getShortlistUser?->getReligiousInformation?->caste ?? '',
            'gotra' => $this->getShortlistUser?->getReligiousInformation?->gotra ?? '',
            'zodiac' => $this->getShortlistUser?->getReligiousInformation?->zodiac ?? '',
            'country' => $country?->name ?? '',
            'state' => $state?->name ?? '',
            'city' => $city?->name ?? '',
            'user_documents'=> new UserDocumentCollection($this->getShortlistUser?->getDocuments),
        ];
    }
}

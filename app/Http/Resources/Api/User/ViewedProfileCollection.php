<?php

namespace App\Http\Resources\Api\User;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewedProfileCollection extends JsonResource
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

        $country = Country::find($this->getViewedUser?->getLocation?->country);
        $state = State::find($this->getViewedUser?->getLocation?->state);
        $city = City::find($this->getViewedUser?->getLocation?->city);

        return [
            'id' => $this->id,
            'user_id' => $this->getViewedUser?->id,
            'first_name' => $this->getViewedUser?->first_name ?? '',
            'last_name' => $this->getViewedUser?->last_name ?? '',
            'age' => $this->getViewedUser?->age ?? '',
            'dob' => $this->getViewedUser?->dob ?? '',
            'visit_count' => $this->visit_count,
            'about_me' => $this->getViewedUser?->about_me ?? '',
            'profile_photo' => $profile_pic ?? '',
            'profile_type' => $this->getViewedUser?->profile_type ?? '',
            'height' => $this->getViewedUser?->getProfileBasicDetails?->height ?? '',
            'religion' => $this->getViewedUser?->religion ?? '',
            'community' => $this->getViewedUser?->community ?? '',
            'caste' => $this->getViewedUser?->getReligiousInformation?->caste ?? '',
            'gotra' => $this->getViewedUser?->getReligiousInformation?->gotra ?? '',
            'zodiac' => $this->getViewedUser?->getReligiousInformation?->zodiac ?? '',
            'country' => $country?->name ?? '',
            'state' => $state?->name ?? '',
            'city' => $city?->name ?? '',
            'user_documents'=> new UserDocumentCollection($this->getViewedUser?->getDocuments),
        ];
    }
}

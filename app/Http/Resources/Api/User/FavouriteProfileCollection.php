<?php

namespace App\Http\Resources\Api\User;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteProfileCollection extends JsonResource
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

        $country = Country::find($this->getFavouriteUser?->getLocation?->country);
        $state = State::find($this->getFavouriteUser?->getLocation?->state);
        $city = City::find($this->getFavouriteUser?->getLocation?->city);

        return [
            'id' => $this->id,
            'user_id' => $this->getFavouriteUser?->id,
            'first_name' => $this->getFavouriteUser?->first_name ?? '',
            'last_name' => $this->getFavouriteUser?->last_name ?? '',
            'age' => $this->getFavouriteUser?->age ?? '',
            'dob' => $this->getFavouriteUser?->dob ?? '',
            'about_me' => $this->getFavouriteUser?->about_me ?? '',
            'profile_photo' => $profile_pic ?? '',
            'profile_type' => $this->getFavouriteUser?->profile_type ?? '',
            'height' => $this->getFavouriteUser?->getProfileBasicDetails?->height ?? '',
            'religion' => $this->getFavouriteUser?->religion ?? '',
            'community' => $this->getFavouriteUser?->community ?? '',
            'caste' => $this->getFavouriteUser?->getReligiousInformation?->caste ?? '',
            'gotra' => $this->getFavouriteUser?->getReligiousInformation?->gotra ?? '',
            'zodiac' => $this->getFavouriteUser?->getReligiousInformation?->zodiac ?? '',
            'country' => $country?->name ?? '',
            'state' => $state?->name ?? '',
            'city' => $city?->name ?? '',
            'user_documents'=> new UserDocumentCollection($this->getFavouriteUser?->getDocuments),
        ];
    }
}

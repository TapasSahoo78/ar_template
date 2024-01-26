<?php

namespace App\Http\Resources\Api\User;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\User\UserPreferenceCollection;
use App\Http\Resources\Api\User\BasicInformationCollection;


class ProfileCollection extends JsonResource
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

        return [
            'id' => $this->id,
            'first_name' => $this->first_name ?? '',
            'last_name' => $this->last_name ?? '',
            'dob' => $this->dob ?? '',
            'age' => $this->age ?? '',
            'profile_photo' => $profile_pic ?? '',
            'profile_type' => $this->profile_type ?? '',
            'about_me' => $this->about_me ?? '',
            'contact_number' => $this->contact_number ?? NULL,
            'email' => $this->email ?? NULL,
            'religion' => $this->religion ?? '',
            'community' => $this->community ?? '',
            'basic_details'=> new BasicInformationCollection($this->getProfileBasicDetails),
            'religious_information'=> new ReligiousInformationCollection($this->getReligiousInformation),
            'location_information'=> new LocationInformationCollection($this->getLocation),
            'professional_information'=> new ProfessionalInformationCollection($this->getProfessionalInformation),
            'family_information'=> new FamilyInformationCollection($this->getFamilyDetails),
            'hobbies_&_interest'=> new HobbiesCollection($this->getHobbies),
            'user_image' => ($this->getUserImage->count() > 0) ? UserImageCollection::collection($this->getUserImage) : null,
            'user_documents'=> new UserDocumentCollection($this->getDocuments),
            'user_preference'=> new UserPreferenceCollection($this->getUserPreference),
        ];
    }
}

<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class FamilyInformationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        return [
            'family_values' => $this->family_values ?? '',
            'family_type' => $this->family_type ?? '',
            'family_status' => $this->family_status ?? '',
            'fathers_occupation' => $this->fathers_occupation ?? '',
            'mothers_occupation' => $this->mothers_occupation ?? '',
            'about_my_family' => $this->about_my_family ?? '',
        ];
    }
}

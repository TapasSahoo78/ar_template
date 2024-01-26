<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionalInformationCollection extends JsonResource
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
            'education_category' => $this->education_category ?? '',
            'college' => $this->college ?? '',
            'occupation' => $this->occupation ?? '',
            'organization' => $this->organization ?? '',
            'employed_in' => $this->employed_in ?? '',
            'annual_income' => $this->annual_income ?? '',
        ];
    }
}

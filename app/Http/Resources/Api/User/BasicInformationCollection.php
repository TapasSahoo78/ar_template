<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasicInformationCollection extends JsonResource
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
            // 'first_name' => $this->getUser?->first_name ?? '',
            // 'last_name' => $this->getUser?->last_name ?? '',
            // 'dob' => $this->getUser?->dob ?? '',
            // 'age' => $this->getUser?->age ?? '',
            'height' => $this->height ?? '',
            'weight' => $this->weight ?? '',
            'marital_status' => $this->marital_status ?? '',
            'mother_tongue' => $this->mother_tongue ?? '',
            'physical_status' => $this->physical_status ?? '',
            'body_type' => $this->body_type ?? '',
            'gender' => $this->gender ?? '',
            'eating_habits' => $this->eating_habits ?? '',
            'profile_created_by' => $this->profile_created_by ?? '',
            'smoking_habits' => $this->smoking_habits ?? '',
            'drinking_habits' => $this->drinking_habits ?? '',
        ];
    }
}

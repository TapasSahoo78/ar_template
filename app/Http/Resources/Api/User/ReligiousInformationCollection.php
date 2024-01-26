<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ReligiousInformationCollection extends JsonResource
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
            // 'religion' => $this->getUser?->religion ?? '',
            // 'community' => $this->getUser?->community ?? '',
            'caste' => $this->caste ?? '',
            'gotra' => $this->gotra ?? '',
            'zodiac' => $this->zodiac ?? '',
            'star' => $this->star ?? '',
            'rassi' => $this->rassi ?? '',
            'dosh' => $this->dosh ?? '',
        ];
    }
}

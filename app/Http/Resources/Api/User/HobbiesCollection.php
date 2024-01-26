<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HobbiesCollection extends JsonResource
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
            'hobbies' => $this->hobbies ?? '',
            'music' => $this->music ?? '',
            'reading' => $this->reading ?? '',
            'moving_and_tv_shows' => $this->moving_and_tv_shows ?? '',
            'sports_and_fitness' => $this->sports_and_fitness ?? '',
            'food' => $this->food ?? '',
            'spoken_languages' => $this->spoken_languages ?? '',
        ];
    }
}

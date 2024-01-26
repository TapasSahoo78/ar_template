<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'authozation_no' => $this->authozation_no,
            'reg_no' => $this->reg_no,
            'name' => $this->name,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'email' => $this->email,
            'image' => $this->image,
            'url' => asset('uploads')
        ];
    }
}

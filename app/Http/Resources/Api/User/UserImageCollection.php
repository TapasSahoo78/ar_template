<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\User\BasicInformationCollection;

class UserImageCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        $image = asset('storage/no-image.png');
        if(!empty($this->file)) {
            $image = asset('storage/user_images') .'/'. $this->file;
        }

        $is_profile_pic = 0;
        if($this->file == $this->getUser?->profile_photo) {
            $is_profile_pic = 1;
        }

        return [
            'id' => $this->id,
            'file' => $image ?? '',
            'is_profile_pic' => $is_profile_pic ?? 0,
        ];
    }
}

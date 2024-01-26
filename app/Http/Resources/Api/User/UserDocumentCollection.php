<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\User\BasicInformationCollection;

class UserDocumentCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        $id_file = asset('storage/no-image.png');
        if(!empty($this->id_file)) {
            $id_file = asset('storage/user_documents/id_file') .'/'. $this->id_file;
        }

        $photo_file = asset('storage/no-image.png');
        if(!empty($this->photo_file)) {
            $photo_file = asset('storage/user_documents/photo_file') .'/'. $this->photo_file;
        }

        $salary_file = asset('storage/no-image.png');
        if(!empty($this->salary_file)) {
            $salary_file = asset('storage/user_documents/') .'/'. $this->salary_file;
        }

        return [
            'id' => $this->id ?? '',
            'id_file_type' => $this->id_file_type ?? '',
            'id_file' => $id_file ?? '',
            'id_status' => $this->id_status ?? '',
            'photo_file' => $photo_file ?? '',
            'photo_status' => $this->photo_status ?? '',
            'salary_file' => $salary_file,
            'salary_status' => $this->salary_status ??'',
        ];
    }
}

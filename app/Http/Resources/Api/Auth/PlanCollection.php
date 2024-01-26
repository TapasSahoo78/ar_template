<?php

namespace App\Http\Resources\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlanCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $discount_percentage = 0;
        if(((!empty($this->price)) && ($this->price > 0)) && ((!empty($this->discount_price)) && ($this->discount_price > 0)) ) {
            $discount_percentage = (int) (($this->discount_price / $this->price) *100);
        }

        return [
            'id' => $this->id ?? '',
            'title' => $this->title ?? '',
            'slug' => $this->slug ?? '',
            'description' => $this->description ?? '',
            'payment_mode' => $this->payment_mode ?? '',
            'price' => $this->price ?? '',
            'discount_price' => $this->discount_price ?? '',
            'discount_percentage' => $discount_percentage ?? '',
        ];
    }
}

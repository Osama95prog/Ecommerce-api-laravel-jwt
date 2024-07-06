<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'image' => $this->image_url,
            'relations' => [
                'user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ],
            ],
        ];
    }
}

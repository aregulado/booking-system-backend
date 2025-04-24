<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'guest_name' => $this->guest_name,
            'room_id' => $this->room_id,
            'check_in_date' => $this->check_in_date->format('Y-m-d'),
            'check_out_date' => $this->check_out_date->format('Y-m-d'),
            'status' => $this->status,
            'promo_code' => $this->promo_code,
            'room' => [
                'id' => $this->room->id,
                'number' => $this->room->number,
                'type' => $this->room->type,
                'is_available' => $this->room->is_available,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}

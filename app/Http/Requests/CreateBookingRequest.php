<?php

namespace App\Http\Requests;

use App\Rules\PromoCodeFormat;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'guest_name' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'promo_code' => ['nullable', 'string', 'max:50', new PromoCodeFormat],
        ];
    }
}

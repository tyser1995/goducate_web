<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOvernightStayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'        => ['required', 'email', 'max:255'],
            'checkin_date' => ['required', 'date', 'after_or_equal:today'],
            'checkout_date'=> ['required', 'date', 'after:checkin_date'],
            'room_type'    => ['nullable', 'string', 'max:100'],
        ];
    }
}

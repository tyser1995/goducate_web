<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'min:2', 'max:255'],
            'email'            => ['required', 'email', 'max:255'],
            'address'          => ['required', 'string', 'max:500'],
            'contact_no'       => ['required', 'string', 'max:20'],
            'no_of_adults'     => ['required', 'integer', 'min:1', 'max:100'],
            'no_of_children'   => ['required', 'integer', 'min:0', 'max:100'],
            'booking_status'   => ['required', 'integer', 'in:0,1,2'],
            'accomodation_id'  => ['required'],
            'accomodation_id.*'=> ['exists:accomodations,id'],
            'checkin_date'     => ['required', 'date', 'after_or_equal:today'],
            'checkout_date'    => ['required', 'date', 'after:checkin_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'checkin_date.after_or_equal' => 'Check-in date must be today or a future date.',
            'checkout_date.after'         => 'Check-out date must be after the check-in date.',
            'accomodation_id.required'    => 'Please select at least one accommodation.',
        ];
    }
}

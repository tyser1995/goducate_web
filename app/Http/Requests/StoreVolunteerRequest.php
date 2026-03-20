<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVolunteerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'  => ['required', 'string', 'min:2', 'max:100'],
            'last_name'   => ['required', 'string', 'min:2', 'max:100'],
            'email'       => ['required', 'email', 'max:255'],
            'contact_no'  => ['required', 'string', 'max:20'],
            'address'     => ['required', 'string', 'max:500'],
            'birthdate'   => ['nullable', 'date', 'before:today'],
            'gender'      => ['nullable', 'string', 'in:Male,Female,Other'],
        ];
    }
}

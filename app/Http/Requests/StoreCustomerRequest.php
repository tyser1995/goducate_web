<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'       => ['required', 'string', 'min:2', 'max:100'],
            'last_name'        => ['required', 'string', 'min:2', 'max:100'],
            'middle_name'      => ['nullable', 'string', 'max:100'],
            'email'            => ['required', 'email', 'max:255', 'unique:customers,email'],
            'contact_no'       => ['required', 'string', 'max:20'],
            'address'          => ['required', 'string', 'max:500'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
            'confirm_password' => ['required'],
        ];
    }
}

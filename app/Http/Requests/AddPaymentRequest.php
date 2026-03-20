<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'attachment'  => [
                'nullable',
                'file',
                'mimes:jpeg,jpg,png,pdf',
                'max:5120', // 5 MB
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'attachment.mimes' => 'Payment proof must be a JPEG, PNG, or PDF file.',
            'attachment.max'   => 'Payment proof may not be larger than 5 MB.',
        ];
    }
}

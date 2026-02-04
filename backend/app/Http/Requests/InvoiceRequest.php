<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,partial,canceled',
            'payment_method' => 'required|string|in:cash,other',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'amount.required' => 'Payment amount is required.',
            'amount.numeric' => 'Payment amount must be a number.',
            'amount.min' => 'Payment amount must be at least 0.',
            'status.required' => 'Invoice status is required.',
            'status.in' => 'Invoice status must be one of: paid, partial, canceled.',
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Payment method must be either cash or other.',
        ];
    }
}

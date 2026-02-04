<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipRequest extends FormRequest
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
        $rules = [
            'member_id' => 'required|exists:members,id',
            'plan_id' => 'required|exists:plans,id',
            'duration' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,partial,canceled',
            'payment_method' => 'required|string|in:cash,other',
            'note' => 'nullable|string|max:500',
        ];

        // For updates, allow status changes
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = [
                'status' => 'required|string|in:active,canceled,expired,frozen',
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'member_id.required' => 'Member is required.',
            'member_id.exists' => 'Selected member does not exist.',
            'plan_id.required' => 'Plan is required.',
            'plan_id.exists' => 'Selected plan does not exist.',
            'duration.required' => 'Duration is required.',
            'duration.integer' => 'Duration must be a whole number.',
            'duration.min' => 'Duration must be at least 1 day.',
            'total_amount.required' => 'Total amount is required.',
            'total_amount.numeric' => 'Total amount must be a number.',
            'amount.required' => 'Payment amount is required.',
            'amount.numeric' => 'Payment amount must be a number.',
            'status.in' => 'Status must be one of: paid, partial, canceled, active, expired, frozen.',
            'payment_method.in' => 'Payment method must be either cash or other.',
        ];
    }
}

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
        return [
            // membership
            'member_id' => 'required|exists:members,id',
            'plan_id'   => 'required|exists:plans,id',
            'duration'  => 'required|integer|min:1',

            // payment
            'amount'    => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,other',
            'note' => 'nullable|string|max:255',

            // invoice
            'total_amount'   => 'required|numeric|min:0',
            'status'        => 'required|string|in:paid,unpaid,partial,canceled',
        ];
    }
}

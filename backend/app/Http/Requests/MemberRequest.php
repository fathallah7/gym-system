<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:members,email,' . $this->member->id,
            'phone_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'status' => 'nullable|string|max:255',
        ];
    }

}

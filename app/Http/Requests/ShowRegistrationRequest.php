<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Registration confirmations are publicly accessible via registration number.
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
            // Route model binding handles registration validation
        ];
    }
}

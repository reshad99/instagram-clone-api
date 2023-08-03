<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $unique = Rule::unique('users')->ignore($this->user()->id);
        return [
            'email' => ['required', 'email', 'max:255', $unique],
            'phone' => ['required', 'max:255', $unique],
            'username' => ['required', 'max:255', $unique],
            'gender' => ['nullable', 'in:male,female'],
            'birth_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'image' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:5120'],
        ];
    }
}

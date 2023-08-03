<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:users,id|email|max:255',
            'username' => 'required|unique:users,id|email|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'phone' => 'required|unique:users,phone|max:255',
            'username' => 'required|max:255|unique:users,username',
            'password' => 'required|confirmed|min:8',
        ];
    }
}

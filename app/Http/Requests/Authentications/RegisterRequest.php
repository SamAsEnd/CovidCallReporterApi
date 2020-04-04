<?php

namespace App\Http\Requests\Authentications;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => 'required|min:4|max:255',
            'phone' => 'required|min:9|max:13|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255'
        ];
    }
}

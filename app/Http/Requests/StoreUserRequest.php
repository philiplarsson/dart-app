<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (requestContainsMultipleObjects()) {
            return [
                '*.username' => 'required|max:30|unique:users',
                '*.email' => 'required|email|max:255|unique:users',
                '*.password' => 'required|min:6',
                '*.name' => 'string:max:255',
            ];
        } else {
            return [
                'username' => 'required|max:30|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
                'name' => 'string:max:255',
            ];
        }
    }
}

<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('id');

        if (!isset($id)) {
            // updateMultiple request
            return $this->user()->isAdmin();
        }

        $user = User::find($id);

        return $user && $this->user()->can('update', $user);
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
                '*.id' => 'required|integer|exists:users,id',
                '*.username' => 'max:30|unique:users',
                '*.email' => 'email|max:255|unique:users',
                '*.name' => 'string:max:255'
            ];
        } else {
            return [
                'username' => 'max:30|unique:users',
                'email' => 'email|max:255|unique:users',
                'name' => 'string:max:255',
            ];
        }

    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameTypeRequest extends FormRequest
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
                '*.id' => 'required|exists:game_types,id',
                '*.name' => 'max:50|unique:game_types',
                '*.description' => 'string:max:1024',
            ];
        } else {
            return [
                'name' => 'max:50|unique:game_types',
                'description' => 'string:max:1024',
            ];

        }

    }
}

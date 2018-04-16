<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
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
                '*.id' => 'required|integer|exists:games,id',
                '*.game_type_id' => 'required|integer|exists:game_types,id'
            ];
        } else {
            return [
                'game_type_id' => 'required|integer|exists:game_types,id',
            ];

        }

    }
}

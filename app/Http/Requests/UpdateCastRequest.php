<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCastRequest extends FormRequest
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
                '*.throws_id' => 'required|integer|exists:throws,id',
                '*.user_id' => 'integer|exists:users,id',
                '*.game_id' => 'integer|exists:games,id',
                '*.pie_value' => 'integer|exists:points,pie_value',
                '*.multiplier' => 'integer|exists:multipliers,value'
            ];
        } else {
            return [
                'user_id' => 'integer|exists:users,id',
                'game_id' => 'integer|exists:games,id',
                'pie_value' => 'integer|exists:points,pie_value',
                'multiplier' => 'integer|exists:multipliers,value'
            ];
        }
    }
}

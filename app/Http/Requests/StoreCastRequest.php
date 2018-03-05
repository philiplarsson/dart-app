<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCastRequest extends FormRequest
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
        return [
            'user_id' => 'required|integer|exists:users,id',
            'game_id' => 'required|integer|exists:games,id',
            'pie_value' => 'required|integer|exists:points,pie_value',
            'multiplier' => 'required|integer|exists:multipliers,value'
        ];
    }
}

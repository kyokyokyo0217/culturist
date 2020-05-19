<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrack extends FormRequest
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
            'track' => 'required|file|mimes:mpga',
            'artwork' => 'required|file|mimes:jpg,jpeg,png',
            'title' => 'required|string|max:255'
        ];
    }
}

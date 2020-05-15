<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfile extends FormRequest
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
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png',
            'cover_photo' => 'nullable|file|mimes:jpg,jpeg,png',
            'bio' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255'
        ];
    }
}

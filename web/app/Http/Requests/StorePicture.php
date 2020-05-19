<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePicture extends FormRequest
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
          'picture' => 'required|file|mimes:jpg,jpeg,png',
          'title' => 'required|string|max:255'
      ];
    }
}

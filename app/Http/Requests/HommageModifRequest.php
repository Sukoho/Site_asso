<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HommageModifRequest extends FormRequest
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
           'titre' => 'required|max:255',
            'message' => 'required',
            'img' => 'required_if:img2,==,null|image|mimes:jpg,png,jpeg,gif|max:50000|dimensions:min_width=100,min_height=100,max_width=10000,max_height=10000',
        ];
    }
}

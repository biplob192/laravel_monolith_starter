<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CropRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'              => 'required',
            'scientific_name'   => 'required',
            'category_id'       => 'required',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description'       => 'required',
        ];
    }
}

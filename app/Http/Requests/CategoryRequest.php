<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
    public function rules()
    {
        return ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store()
    {
        return [
            'name'  => 'required|unique:categories',
            // 'icon'  => 'nullable|image|dimensions:width=128,height=128|mimes:jpeg,png,jpg,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048|dimensions:max_width=128,max_height=128',
        ];
    }

    protected function update()
    {
        return [
            'name'  => ['required', Rule::unique('categories')->ignore($this->route('id'))],
            // 'icon'  => 'nullable|image|dimensions:width=128,height=128|mimes:jpeg,png,jpg,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048|dimensions:max_width=128,max_height=128',
        ];
    }
}

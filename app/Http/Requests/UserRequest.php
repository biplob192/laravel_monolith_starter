<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store()
    {
        return [
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|unique:users,phone',
            'password'      => 'required|confirmed',
            'user_role'     => 'required',
            // 'profile_image'         => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }

    protected function update()
    {
        return [
            'name' => 'required',
            'phone' => ['required', Rule::unique('users')->ignore($this->route('id'))],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->route('id'))],
        ];
    }
}

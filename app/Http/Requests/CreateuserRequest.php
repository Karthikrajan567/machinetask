<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateuserRequest extends FormRequest
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
        return [
            'name' => 'required|max:30|min:2|regex:/^[a-zA-Z0-9\s]*$/',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:16',
            'uuid' => '',
            'company_id' => '',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('message.required'),
            'name.max' => __('message.max'),
            'name.min' => __('message.min'),
            'name.regex' => __('message.alphanumeric'),
            'email.required' => __('message.required'),
            'email.email' => __('message.email'),
            'email.max' => __('message.max'),
            'email.unique' => __('message.unique'),
            'password.required' => __('message.required'),
            'password.min' => __('message.min'),
            'password.max' => __('message.max'),
        ];
    }
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Modify the validated data
        $data['password'] = bcrypt($data['password']);
        $data['company_id'] = auth()->user()->company_id;
        $data['uuid'] = Str::uuid();

        return $data;
    }
}

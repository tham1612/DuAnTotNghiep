<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'fullName' => 'nullable|string|max:255',
            'phone' => [
                'nullable',
                'numeric',
                'digits:10',
                'regex:/^0\d{9}$/'
            ],
            'introduce' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('id')),
            ],
            'password' => 'nullable|string',
            'social_id' => 'nullable|string|max:255',
            'social_name' => 'nullable|string|max:255',
            'image' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'phone.numeric' => 'Số điện thoại phải là một số.',
            'phone.digits' => 'Số điện thoại phải là 10 chữ số.',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có tổng cộng 10 chữ số.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
        ];
    }
}

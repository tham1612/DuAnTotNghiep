<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'text' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|interger',
            'progress' => 'nullable|numeric|min:0|max:100',
            'start_date' => 'nullable|date_format:Y-m-d\TH:i|before:end_date',
            'end_date'   => 'nullable|date_format:Y-m-d\TH:i|after:start_date',
            'reminder_date' => 'nullable|date_format:Y-m-d\TH:i|after:start_date|before:end_date',
            'image' => 'nullable|image',
        ];
    }
    public function messages(){
        return [
            'text.required' => 'Vui lòng nhập tên thẻ.',
            'start_date.before' => 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc.',
            'end_date.after'    => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ];
    }
}
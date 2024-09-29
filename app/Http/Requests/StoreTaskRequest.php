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
           'start_date' => 'nullable|date_format:Y-m-d H:i:s',
            'end_date' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_date',
        ];
    }
    public function messages(){
        return [
            'text.required' => 'Vui lòng nhập tên thẻ.',
            'start_date.date_format' => 'Ngày bắt đầu không đúng định dạng Y-m-d H:i:s.',
            'end_date.date_format' => 'Ngày kết thúc không đúng định dạng Y-m-d H:i:s.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ];
    }
}

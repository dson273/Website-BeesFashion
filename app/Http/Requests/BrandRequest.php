<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name' => 'required|string|max:255', // Quy tắc cho trường 'name'
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Quy tắc cho trường 'image'
            'is_active' => 'required|boolean', // Quy tắc cho trường 'is_active'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên thương hiệu là bắt buộc.',
            'name.string' => 'Tên thương hiệu phải là chuỗi.',
            'name.max' => 'Tên thương hiệu không được vượt quá 255 ký tự.',
            'image.image' => 'Ảnh thương hiệu phải là một tệp hình ảnh.',
            'image.mimes' => 'Ảnh thương hiệu phải có định dạng jpeg, png, jpg, hoặc gif.',
            'is_active.required' => 'Trạng thái hoạt động là bắt buộc.',
            'is_active.boolean' => 'Trạng thái hoạt động phải là true hoặc false.',
        ];
    }
}

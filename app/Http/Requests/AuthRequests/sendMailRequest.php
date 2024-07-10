<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class sendMailRequest extends FormRequest
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
        //Hàm rules trả về 1 mảng xác thực dữ liệu
        return [
            'email' => 'required|email'
        ];
    }

    public function messages(): array
    {
        //Hàm messages trả về 1 mảng thông báo lỗi tương ứng với những điều kiện xác thực trong Rules()
        return [
            'email.required' => 'Bạn chưa nhập vào email.',
            'email.email' => 'Email chưa đúng định dạng. Ví dụ: abc@gmail.com'
        ];
    }
}

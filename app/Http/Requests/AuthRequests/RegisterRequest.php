<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        //Hàm rules trả về 1 mảng xác thực dữ liệu
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        //Hàm messages trả về 1 mảng thông báo lỗi tương ứng với những điều kiện xác thực trong Rules()
        return [
            'email.required' => 'Bạn chưa nhập vào email.',
            'email.email' => 'Email chưa đúng định dạng. Ví dụ: abc@gmail.com',
            'email.unique' => 'Email bạn nhập đã được sử dụng',
            'name.required' => 'Bạn không được để trống họ và tên',
            'password.required' => 'Bạn chưa nhập vào mật khẩu.'
        ];
    }
}

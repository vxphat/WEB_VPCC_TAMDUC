<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostCatalogueRequest extends FormRequest
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
            'name' => 'required||unique:post_catalogues',
            'canonical' => 'required|unique:post_catalogues',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập vào danh mục bài viết.',
            'name.unique' => 'Danh mục bài viết đã tồn tại.',
            'canonical.required' => 'Bạn chưa nhập vào ô đường dẫn.',
            'canonical.unique' => 'Đường dẫn bài viết đã tồn tại.',
        ];
    }
}

<?php
namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id'     => ['required', 'integer', 'exists:products,id'],
            'customer_name'  => ['required', 'string', 'min:2', 'max:100'],
            'customer_phone' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'customer_email' => ['nullable', 'email', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.exists'        => 'Produk tidak ditemukan.',
            'customer_name.required'   => 'Nama wajib diisi.',
            'customer_phone.required'  => 'Nomor telepon wajib diisi.',
            'customer_phone.regex'     => 'Format nomor telepon tidak valid.',
        ];
    }
}
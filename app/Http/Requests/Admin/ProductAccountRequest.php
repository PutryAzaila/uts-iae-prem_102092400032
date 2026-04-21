<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductAccountRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'account_email_or_username' => ['required', 'string', 'max:200'],
            'account_password'          => ['required', 'string', 'max:200'],
            'notes'                     => ['nullable', 'string'],
        ];
    }
}
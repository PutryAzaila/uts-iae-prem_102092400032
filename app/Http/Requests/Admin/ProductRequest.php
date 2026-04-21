<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name'        => ['required', 'string', 'max:200'],
            'slug'        => ['nullable', 'string', Rule::unique('products', 'slug')->ignore($productId)],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['boolean'],
            'thumbnail'   => ['nullable', 'image', 'max:2048'],
        ];
    }
}
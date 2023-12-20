<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductsFormRequest extends FormRequest
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
            'name' => [
                'sometimes',
                'required',
                'min:3',
                'max:255',
                'unique:products,name'
            ],
            'price' => 'required',
            'description' => [
                'required',
                'min:3'
            ],
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'category_id' => [
                'required',
                'exists:categories,id'
            ],
            'image' => 'nullable'
        ];
    }
}

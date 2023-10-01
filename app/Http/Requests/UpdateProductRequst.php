<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequst extends FormRequest
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
            'image' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'category_id' => [Rule::exists('categories','id')],
            'ingredient_ids' => 'array',
            'ingredient_ids.*.id' => [Rule::exists('ingredients' , 'id')],
            'ingredient_ids.*.quantity' => ['numeric']
        ];
    }
}

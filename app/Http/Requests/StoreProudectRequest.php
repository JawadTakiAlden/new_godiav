<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProudectRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'name' => 'required',
            'description' => 'required',
            'category_id' => ['required' , Rule::exists('categories','id')],
            'price' => 'required',
            'calories' => 'required',
            'ingredient_ids' => 'array',
            'ingredient_ids.*.id' => [Rule::exists('ingredients' , 'id')],
            'ingredient_ids.*.quantity' => ['required' , 'numeric']
        ];
    }
}

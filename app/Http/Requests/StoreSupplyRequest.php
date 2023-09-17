<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSupplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => [Rule::exists('suppliers' , 'id')],
            'ingredients' => 'array',
            'ingredients.*.ingredient_id' => [Rule::exists('ingredients' , 'id')],
            'ingredients.*.come_in_quantity' => 'required|numeric',
            'ingredients.*.unit_price' => 'required|numeric',
            'ingredients.*.unit' => 'in:g,kg',

        ];
    }
}

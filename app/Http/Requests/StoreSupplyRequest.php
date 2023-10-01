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
            'branch_id' => ['required' , Rule::exists('branches' , 'id')],
            'ingredients' => 'required|array',
            'ingredients.*.unit_price' => 'required|numeric',
            'ingredients.*.come_in_quantity' => 'required|numeric',
            'ingredients.*.unit' => 'required',
            'ingredients.*.ingredient_id' =>  ['required' , Rule::exists('ingredients' , 'id')]
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'table_id' => ['required' , Rule::exists('tables' , 'id')],
            'order_items' => 'required|array',
            'order_items.*.product_id' => ['required' , Rule::exists('products' , 'id')],
           // 'order_items.*.quantity_id' => ['required' , Rule::exists('products' , 'id')],

        ];
    }
}

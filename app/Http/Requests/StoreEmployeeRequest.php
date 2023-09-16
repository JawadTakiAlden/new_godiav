<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required',
            'serial_number' => 'required|unique:employees,serial_number',
            'password' => 'required|min:7|max:28',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048',
            'branch_id' => ['required' , Rule::exists('branches' , 'id')],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\VarDumper\VarDumper;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('product');
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories','name')->ignore($id),
            ],
                'description' => 'nullable|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'status' => 'in:active,inactive',
                'price' => 'required|numeric|min:0',
                'compare_price' => 'nullable|numeric|gt:price',
            ];
    }
}

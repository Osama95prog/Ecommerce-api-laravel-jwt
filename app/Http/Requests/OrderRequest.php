<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        return [
            'payment_method' => 'required|string|max:255',
            
            'products' => 'required|array',
            'products.*.id' => [  'id' => 'required|exists:products,id' ],
            'products.*.price' => [  'price' => 'required|numeric|min:0' ],
            'products.*.quantity' => [  'quantity' => 'required|integer|min:1' ],

            'address.billing.first_name' => [
                'required', 'string', 'max:255'
            ],
            'address.billing.last_name' => [
                'required', 'string', 'max:255'
            ],
            'address.billing.email' => [
                'required', 'string', 'max:255'
            ],
            'address.billing.phone_number' => [
                'required', 'string', 'max:255'
            ],
            'address.billing.city' => [
                'required', 'string', 'max:255'
            ],
        ];
    }
}

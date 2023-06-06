<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OsProductStockRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'sku' => 'required',
            'price' => 'nullable',
            'accessories' => 'nullable',
            'purchase_date' => 'nullable',
            'life_date' => 'nullable',
            'status' => 'nullable',
            'active' => 'boolean',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OsProductRequest extends FormRequest
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
            'os_category_id' => 'required|exists:os_categories,id',
            'name' => 'required',
            'customization' => 'boolean',
            'active' => 'boolean',
            'price' => 'required',
            // 'brand' => 'required',
            // 'model' => 'required',
            // 'serie' => 'required',
            // 'dimensions' => 'required',
            // 'weight' => 'required',
        ];
    }
}

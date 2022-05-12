<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'tax'        => 'required|present|numeric',
            'products'   => 'required|array|min:1|exists:products,id',
            'status'     => 'required|in:0,1',
            'customer_id' => 'required|exists:customers,id',
        ];
    }
}

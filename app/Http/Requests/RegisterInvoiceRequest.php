<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterInvoiceRequest extends FormRequest
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
            'factura' => 'required|unique:invoices',
            'fecha_factura' => 'required',
            'moneda' => 'required',
            'neto' => 'required',
            'iva' => 'required'
        ];
    }
}

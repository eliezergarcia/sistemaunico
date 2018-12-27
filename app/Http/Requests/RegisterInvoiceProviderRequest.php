<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterInvoiceProviderRequest extends FormRequest
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
            'provider_id' => 'required',
            'factura' => 'required|unique:invoice_providers',
            'invoice_date' => 'required',
            'expense_tipe' => 'required',
            'neto' => 'required',
            'expense_description' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperationRequest extends FormRequest
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
            'shipper' => 'required',
            'master_consignee' => 'required',
            'house_consignee' => 'required',
            'eta' => 'required',
            'etd' => 'required',
            'impo_expo' => 'required',
            'pol' => 'required',
            'pod' => 'required',
            'destino' => 'required',
            'incoterm' => 'required',
            'vessel' => 'required',
            'c_invoice' => 'required',
            'm_bl' => 'required',
            'h_bl' => 'required',
            'aa' => 'required'
        ];
    }
}

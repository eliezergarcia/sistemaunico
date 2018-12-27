<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterClientRequest extends FormRequest
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
            'codigo_cliente' => 'required',
            'razon_social' => 'required',
            'rfc' => 'required',
            'calle' => 'required',
            'colonia' => 'required',
            'codigo_postal' => 'required',
            'pais' => 'required',
            'estado' => 'required',
            'ciudad' => 'required',
            'municipio' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuiaRequest extends FormRequest
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
            'data_limite' => 'required',
            'prioridade' => 'required',
            'reclamante' => 'required',
            'perfil_pagamento' => 'required',
            'banco' => 'required',
            'anexo_pdf' => 'mimes:application/pdf,pdf',
        ];
    }
}

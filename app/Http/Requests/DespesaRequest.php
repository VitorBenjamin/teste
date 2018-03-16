<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DespesaRequest extends FormRequest
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
            'descricao' => 'required',
            'data_despesa' => 'required',
            'tipo_comprovante' => 'required',
            'valor' => 'required',
            'anexo_comprovante' => 'mimes:jpeg,png,pdf',
            // 'anexo_comprovante' => 'required:image',
        ];
    }
}
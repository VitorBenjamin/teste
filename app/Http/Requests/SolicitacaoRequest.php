<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitacaoRequest extends FormRequest
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
            // 'processo' => 'exists:mysql.processos,codigo',
            'urgente' => 'required',
            'origem_despesa' => 'required',
            'contrato' => 'required',
            'area_atuacoes_id'=> 'required',
            'clientes_id' => 'required_unless:origem_despesa,ESCRITÓRIO',
            'solicitantes_id' => 'required_unless:origem_despesa,ESCRITÓRIO',
        ];
    }
}

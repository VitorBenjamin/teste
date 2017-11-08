<?php
 
namespace App\Repositories;

use App\Despesa;
use App\Processo;
use App\Translado;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;
 
class SolicitacaoRepository
{

    public function __construct()
    {

    }
    public function create($request,$tipo)
    {
        
        $data = self::montaData($request);
        $data['codigo'] = random_int(100, 99999);
        $data['tipo'] = $tipo;
 
        if ($request->processo != "") {
            $processo = Processo::where('codigo',$request->processo)->first();
            if ($processo != "") {
               
               $data['processos_id'] = $processo->id;
            }
        }

        $solicitacao = Solicitacao::create($data);
        
        $status = Status::where('descricao',config('constantes.status_aberto'))->first();
      //$status = Status::where('descricao','ABERTO')->orWhere('descricao' , 'ANDAMENTO')->get();        
        $solicitacao->status()->attach($status);
      
        return $solicitacao;
    }

    private function montaData($data)
    {

        $dados = [   

            'urgente' => $data->urgente,
            'origem_despesa' => $data->origem_despesa,
            'contrato' => $data->contrato,
            'area_atuacoes_id'=>$data->area_atuacoes_id,
            'clientes_id' => $data->clientes_id,
            'solicitantes_id' => $data->solicitantes_id,
            'unidades_id' => 1,
            'users_id' => 1,
        ];
        return $dados;
    }

    public function getSolicitacao($status)
    {
        
        $status = Status::with(['solicitacao' => function($q){
            $q->select('id','codigo', 'urgente', 'tipo', 'origem_despesa', 'contrato')->take(10);
        }])->where('descricao',$status)->first();

        return $status;
    }

    public function update($request,$id)
    {
        $data = self::montaData($request);

        if ($request->processo != "") {
            $processo = Processo::where('codigo',$request->processo)->first();
            if ($processo != "") {
               
               $data['processos_id'] = $processo->id;
            }
        }

        $solicitacao = Solicitacao::where('id',$id)->update($data);
        
        return $solicitacao;
    }
}
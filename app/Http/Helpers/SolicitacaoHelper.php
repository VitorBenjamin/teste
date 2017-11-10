<?php
namespace App\Http\Helpers;

use App\Despesa;
use App\Processo;
use App\Translado;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;
 
class SolicitacaoHelper
{

    public function __construct()
    {

    }

    public function verificarStatus($solicitacao)
    {
        foreach ($solicitacao->status as $status) {
            
            if ($status->descricao == config('constantes.status_aberto')) {
                
                return "ok";
            }elseif ($status->descricao == config('constantes.status_andamento')) {
               
                \Session::flash('flash_message',[
                    'msg'=>"Solicitação em Andamento. Aguarde um Parecer da Coordenação ",
                    'class'=>"alert bg-green alert-dismissible"

                ]);

                return redirect()->route('solicitacao.index');
            }   
        }
    }

    public  function solicitacaoExist($solicitacao, $tipo)
    {
        
        if(!$solicitacao){
            \Session::flash('flash_message',[
                'msg'=>"Não Existe essa Solicitacao Cadastrada!!! Deseja Cadastrar uma Nova Solicitação?",
                'class'=>"alert bg-red alert-dismissible"

            ]);
            return redirect()->route(strtolower($tipo).'.cadastrar');            
        }else{
            return "ok";
        }

    }

}
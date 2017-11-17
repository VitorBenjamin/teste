<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SolicitacaoHelper;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Repositories\SolicitacaoRepository;
use App\Processo;
use App\Viagem;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;

class ViagemController extends Controller
{


    //Retorna a View de cadastro da unidade
    public function cadastrar()
    {
        $areas = AreaAtuacao::all('id','tipo');
        $processos = Processo::all();
        return view('viagem.cadastrar', compact('areas','processos'));  
    }

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
    public function salvar(SolicitacaoRequest $request)
    {   
        $repo = new SolicitacaoRepository();
        $solicitacao = $repo->create($request,config('constantes.tipo_viagem'));

        \Session::flash('flash_message',[
            'msg'=>"Cadastro da ".$solicitacao->tipo." Realizada com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);

        return redirect()->route('viagem.editar', $solicitacao->id);
    }

    public function analisar($id)
    {

        $solicitacao = Solicitacao::with('viagem','cliente','solicitante','processo','area_atuacao')->where('id',$id)->first();
        //dd($solicitacao);

        return view('coordenador.analiseViagem', compact('solicitacao'));

    }


    public function verificarSolicitacao($id)
    {
        $solicitacao = Solicitacao::with('viagem')
        ->where('tipo',config('constantes.tipo_viagem'))
        ->where('id',$id)
        ->first();
        $solicitacaoHelper = new SolicitacaoHelper();
        $exist = $solicitacaoHelper->solicitacaoExist($solicitacao,config('constantes.tipo_reembolso'));
        if ($exist == "ok") 
        {
            $verificarStatus = $solicitacaoHelper->verificarStatus($solicitacao);
            if ($verificarStatus == "ok") 
            {
                return $this->editar($solicitacao);           
            }else{
                return $solicitacaoHelper->verificarStatus($solicitacao);
            }

        }else{
            return $exist;
        }
    }

    //Retorna a View de edição da unidade
    public function editar($soli)
    {
        $solicitacao = $soli;
        
        $cliente = Cliente::where('id',$solicitacao->clientes_id)->select('id','nome')->get();
        $areas = AreaAtuacao::all('id','tipo'); 
        $solicitante = Solicitante::where('id',$solicitacao->solicitantes_id)->select('id','nome')->get();

        return view('viagem.editar', compact('solicitacao','cliente','areas','solicitante'));
    }

    //Atualiza uma viagem e redireciona para a tela de edição da Solicitação
    public function atualizarViagem(Request $request,$id)
    {   
        $viagem = viagem::find($id);
        
        $viagem->update($request->all());

        //dd($viagem);
        \Session::flash('flash_message',[
            'msg'=>"Viagem Atualizada com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('viagem.editar', $viagem->solicitacoes_id);
    }
    public function addViagem(Request $request,$id){
        
        Viagem::create(
            [
                'observacao' => $request->observacao,
                'origem' => $request->origem,
                'destino' => $request->destino, 
                'data_ida' => $request->data_ida,
                'data_volta' => $request->data_volta, 
                'hospedagem' => $request->hospedagem,
                'bagagem' => $request->bagagem, 
                'kg' => $request->kg,
                'solicitacoes_id' => $id,                

            ]
        );
        \Session::flash('flash_message',[
            'msg'=>"Viagem Cadastrada com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('viagem.editar',$id);
    }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
    public function deletarViagem($id)
    {        

        $viagem = Viagem::find($id);
        $s_id = $viagem->solicitacoes_id;
        $viagem->delete();
        \Session::flash('flash_message',[
            'msg'=>"Viagem Removida com Sucesso!!!",
            'class'=>"alert bg-red alert-dismissible"
        ]);
        return redirect()->route('viagem.editar',$s_id);       
    }
    
    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    public function atualizarCabecalho(Request $request,$id)
    {   
        $repo = new SolicitacaoRepository();
        $solicitacao = $repo->update($request,$id);

        \Session::flash('flash_message',[
            'msg'=>"Solicitação Atualizada com Sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('viagem.editar',$id);
    }

}

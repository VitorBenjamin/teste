<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViagemController extends Controller
{
   public function index()
    {
    	
    	$viagem = Viagem::orderBy('localidade');
    	return view('reembolso.index',compact('viagem'));
    }


    //Retorna a View de cadastro da unidade
    public function cadastrar()
    {
    	$clientes = Cliente::all('id','nome');
    	$areas = AreaAtuacao::all('id','tipo'); 
    	$solicitantes = Solicitante::all('id','nome');
    	return view('viagem.cadastrar', compact('clientes','areas','solicitantes')); 	
    }

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
    public function salvar(SolicitacaoRequest $request)
    {   
        $repo = new SolicitacaoRepository();
        $solicitacao = $repo->create($request,config('constantes.tipo_viagem'));
        
        \Session::flash('flash_message',[
            'msg'=>"Cadastro da ".$solicitacao->tipo." Realizado com Sucesso!!!",
            'class'=>"alert-success"
        ]);

        return redirect()->route('viagem.editar', $solicitacao->id);
    }

    //Retorna a View de edição da Solicitação de Viagem
    public function editar($id) 
    {
        $solicitacao = Solicitacao::with('viagem')->where('id',$id)->first();
        if(!$viagem){
            \Session::flash('flash_message',[
                'msg'=>"Não Existe essa Solicitação de Viagem Cadastrada!!! Deseja Cadastrar uma Nova Solicirtação?",
                'class'=>"alert-danger"
            ]);
            return redirect()->route('viagem.cadastrar');            
        }
        $clientes = Cliente::all('id','nome');
        $areas = AreaAtuacao::all('id','tipo'); 
        $solicitantes = Solicitante::all('id','nome');

        return view('viagem.editar', compact('viagem','clientes','areas','solicitantes'));
    }

    //Atualiza uma unidade e redireciona para a tela de listagem de viagem
    public function atualizar(Request $request,$id)
    {   
        $repo = new ViagemRepository();
        $viagem = $repo->update($request,$id);

        \Session::flash('flash_message',[
            'msg'=>"Solicitação Atualizada com Sucesso!!!",
            'class'=>"alert-success"
        ]);
        return redirect()->route('viagem.editar',$id);
    }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de viagem
    public function deletar($id)
    {
        $unidade = Viagem::find($id);
        $unidade->delete();

        \Session::flash('flash_message',[
            'msg'=>"Viagem Removida com Sucesso!!!",
            'class'=>"alert-danger"
        ]);
        return redirect()->route('viagem.index');    	
    }
}

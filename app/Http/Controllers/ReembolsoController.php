<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Despesa;
use App\Translado;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;


class ReembolsoController extends Controller
{
    //buscando todas as informações das solicitacao e enviando para a view de listagem das solicitacao
    public function index(){
    	
    	$solicitacao = Solicitacao::orderBy('localidade');
    	return view('reembolso.index',compact('solicitacao'));
    }

    //Retorna a View de cadastro da unidade
    public function cadastrar(){
    	$clientes = Cliente::all('id','nome');
    	$areas = AreaAtuacao::all('id','tipo'); 
    	$solicitantes = Solicitante::all('id','nome');
    	return view('reembolso.cadastrar', compact('clientes','areas','solicitantes')); 	
    }

    //Cadatra uma unidade e redireciona novamente para um tela de cadastro
    public function salvar(Request $request ){

        $solicitacao = Solicitacao::create(
            [   
                'codigo' => 13224,
                'urgente' => true,
                'tipo' => 'Reembolso',
                'origem_despesa' => $request->origem_despesa,
                'contrato' => $request->contrato,
                'area_atuacoes_id'=>$request->area_atuacoes_id,
                'clientes_id' => $request->clientes_id,
                'solicitantes_id' => $request->solicitantes_id,
                'users_id' => 1,
            ]
        );

        $translado = Translado::create(
            [   
                'data_translado' => $request->data_translado,
                'observacao' => $request->observacao,
                'origem' => $request->origem,
                'destino' => $request->destino,
                'ida_volta' => $request->ida_volta,
                'distancia'=>$request->distancia,
                'solicitacoes_id' => $solicitacao->id,
            ]
        );
        $file = $request->file('anexo_comprovante');
        //dd($file);
        $name = $file->getPathName();
        $file = base64_encode(file_get_contents($name));
        //dd($file);
        $src  = 'data: image/jpeg;base64,'.$file;
        $despesa = Despesa::create(
            [   
                'descricao' => $request->descricao,
                'data_despesa' => $request->data_despesa,
                'tipo_comprovante' => $request->tipo_comprovante,
                'valor' => $request->valor,
                'anexo_comprovante' => base64_encode($request->anexo_comprovante),
                'solicitacoes_id' => $solicitacao->id,
            ]
        );

        //dd($despesa->anexo_comprovante);

      //   \Session::flash('flash_message',[
      //     'msg'=>"Cadastro do Unidade realizado com sucesso!!!",
      //     'class'=>"alert-success"
      // ]);
        return view('reembolso.teste', compact('src'));
      //   return redirect()->route('reembolso.cadastrar');
    }

    //Retorna a View de edição da unidade
    public function editar($id){
    	$unidade = Solicitacao::find($id);
    	if(!$unidade){
    		\Session::flash('flash_message',[
              'msg'=>"Não existe essa Unidade cadastrada!!! Deseja cadastrar uma nova Unidade?",
              'class'=>"alert-danger"
          ]);
    		return redirect()->route('reembolso.cadastrar');
    	}
    	return view('reembolso.editar',compact('unidade'));
    }

     //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
    public function atualizar(Request $request,$id){
      Solicitacao::find($id)->update($request->all());

      \Session::flash('flash_message',[
          'msg'=>"Unidade atualizado com sucesso!!!",
          'class'=>"alert-success"
      ]);
      return redirect()->route('reembolso.index');    	
  }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
  public function deletar($id){
      $unidade = Solicitacao::find($id);
      if(!$Unidade->deletarUnidade()){
       \Session::flash('flash_message',[
          'msg'=>"Registro não pode ser deletado!!!",
          'class'=>"alert-danger"
      ]);
       return redirect()->route('reembolso.index');
   }
   $unidade->delete();

   \Session::flash('flash_message',[
      'msg'=>"Unidade apagada com sucesso!!!",
      'class'=>"alert-danger"
  ]);
   return redirect()->route('reembolso.index');    	
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidade;

class UnidadeController extends Controller
{
    //buscando todas as informações das Unidades e enviando para a view de listagem das unidades
    public function index(){
    	
    	$unidades = Unidade::orderBy('localidade');
    	return view('unidade.index',compact('unidades'));
    }

    public function getUnidades(Request $search){

        $unidades = Unidade::where('localidade','like','%'.$search->q.'%')
        ->select('id','localidade')
        ->get();
        //$unidades = Unidade::all('id','localidade');

       // dd($unidades);
        return response()->json(array("unidades" => $unidades));
    }

    //Retorna a View de cadastro da unidade
    public function cadastrar(){
    	return view('unidade.cadastrar');	
    }

    //Cadatra uma unidade e redireciona novamente para um tela de cadastro
    public function salvar(\App\Http\Requests\UnidadeRequest $request){
    	Unidade::create($request->all());

    	\Session::flash('flash_message',[
    		'msg'=>"Cadastro do Unidade realizado com sucesso!!!",
    		'class'=>"alert-success"
    		]);

    	return redirect()->route('unidade.cadastrar');
    }

    //Retorna a View de edição da unidade
    public function editar($id){
    	$unidade = Unidade::find($id);
    	if(!$unidade){
    		\Session::flash('flash_message',[
              'msg'=>"Não existe essa Unidade cadastrada!!! Deseja cadastrar uma nova Unidade?",
              'class'=>"alert-danger"
              ]);
    		return redirect()->route('unidade.cadastrar');
    	}
    	return view('unidade.editar',compact('unidade'));
    }

     //Atualiza uma unidade e redireciona para a tela de listagem de unidades
    public function atualizar(Request $request,$id){
      Unidade::find($id)->update($request->all());

      \Session::flash('flash_message',[
          'msg'=>"Unidade atualizado com sucesso!!!",
          'class'=>"alert-success"
          ]);
      return redirect()->route('unidade.index');    	
  }

    //Deleta ou Não uma unidade e redireciona para a tela de listagem de unidades
  public function deletar($id){
      $unidade = Unidade::find($id);
      if(!$Unidade->deletarUnidade()){
         \Session::flash('flash_message',[
          'msg'=>"Registro não pode ser deletado!!!",
          'class'=>"alert-danger"
          ]);
         return redirect()->route('Unidade.index');
     }
     $unidade->delete();

     \Session::flash('flash_message',[
      'msg'=>"Unidade apagada com sucesso!!!",
      'class'=>"alert-danger"
      ]);
     return redirect()->route('unidade.index');    	
 }
}

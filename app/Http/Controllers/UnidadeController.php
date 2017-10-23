<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    
    public function index(){
    	
    	//buscando todas as informações das Unidades
    	$unidades = \App\Unidades::orderBy('id');
    	return view('unidade.index',compact('unidades'));
    }

    public function cadastrar(){
    	return view('unidade.cadastrar');	
    }

    public function salvar(\App\Http\Requests\UnidadeRequest $request){
    	\App\Unidade::create($request->all());

    	\Session::flash('flash_message',[
    		'msg'=>"Cadastro do Unidade realizado com sucesso!!!",
    		'class'=>"alert-success"
    		]);

    	return redirect()->route('unidade.cadastrar');
    }

    public function editar($id){
    	$unidade = \App\Unidade::find($id);
    	if(!$unidade){
    		\Session::flash('flash_message',[
    		'msg'=>"Não existe essa Unidade cadastrada!!! Deseja cadastrar uma nova Unidade?",
    		'class'=>"alert-danger"
    		]);
    		return redirect()->route('unidade.cadastrar');
    	}
    	return view('unidade.editar',compact('unidade'));
    }

     public function atualizar(Request $request,$id){
    		\App\Unidade::find($id)->update($request->all());
    	
    		\Session::flash('flash_message',[
    		'msg'=>"Unidade atualizado com sucesso!!!",
    		'class'=>"alert-success"
    		]);
    		return redirect()->route('unidade.index');
    	
    }

    public function deletar($id){
    		$unidade = \App\Unidade::find($id);

    		//if($Unidade->deletarUnidade()){
    		//	\Session::flash('flash_message',[
    		//'msg'=>"Registro não pode ser deletado!!!",
    		//'class'=>"alert-danger"
    		//]);
    		//return redirect()->route('Unidade.index');
    	    //}
    		
    		$unidade->delete();
    	
    		\Session::flash('flash_message',[
    		'msg'=>"Unidade apagada com sucesso!!!",
    		'class'=>"alert-danger"
    		]);
    		return redirect()->route('unidade.index');
    	
    }
}

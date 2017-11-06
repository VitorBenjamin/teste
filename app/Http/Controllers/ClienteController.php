<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller
{
    

    public function getCliente(Request $search){

        $clientes = Cliente::where('nome','like','%'.$search->q.'%')
        ->select('id','nome') 
        ->get();

        return response()->json(array("clientes" => $clientes));
    }

    //buscando todas as informações dos clientes e enviando para a view de listagem das clientes
    public function index(){
    	
    	$clientes = Cliente::orderBy('id');
    	return view('cliente.index',compact('clientes'));
    }

    //Retorna a View de cadastro da cliente
    public function cadastrar(){
    	return view('cliente.cadastrar');	
    }
   
    //Cadatra um cliente e redireciona novamente para um tela de cadastro
    public function salvar(\App\Http\Requests\ClienteRequest $request){
    	Cliente::create($request->all());

    	\Session::flash('flash_message',[
    		'msg'=>"Cadastro do Cliente realizado com sucesso!!!",
    		'class'=>"alert-success"
    		]);

    	return redirect()->route('cliente.cadastrar');
    }
   
    //Retorna a View de edição da cliente
    public function editar($id){
    	$cliente = Cliente::find($id);
    	if(!$cliente){
    		\Session::flash('flash_message',[
    		'msg'=>"Não existe esse Cliente cadastrado!!! Deseja cadastrar um novo Cliente?",
    		'class'=>"alert-danger"
    		]);
    		return redirect()->route('cliente.cadastrar');
    	}
    	return view('cliente.editar',compact('cliente'));
    }

     //Atualiza um cliente e redireciona para a tela de listagem de clientes
     public function atualizar(Request $request,$id){
    		Cliente::find($id)->update($request->all());
    	
    		\Session::flash('flash_message',[
    		'msg'=>"Cliente atualizado com sucesso!!!",
    		'class'=>"alert-success"
    		]);
    		return redirect()->route('cliente.index');    	
    }

    //Deleta ou Não um cliente e redireciona para a tela de listagem de clientes
    public function deletar($id){
    		$cliente = Cliente::find($id);
    		// if(!$cliente->deletarCliente()){
    		// 	\Session::flash('flash_message',[
    		// 'msg'=>"Registro não pode ser deletado!!!",
    		// 'class'=>"alert-danger"
    		// ]);
    		// return redirect()->route('cliente.index');
    	 	// }
    		$cliente->delete();
    	
    		\Session::flash('flash_message',[
    		'msg'=>"Cliente apagado com sucesso!!!",
    		'class'=>"alert-danger"
    		]);
    		return redirect()->route('cliente.index');    	
    }
}

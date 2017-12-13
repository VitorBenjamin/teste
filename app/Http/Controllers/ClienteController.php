<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Unidade;

class ClienteController extends Controller
{


    public function getCliente(Request $search){

        $clientes = Cliente::where('nome','like','%'.$search->q.'%')
        ->select('id','nome') 
        ->get();

        return response()->json(array("clientes" => $clientes));
    }

    //buscando todas as informações dos clientes e enviando para a view de listagem das clientes
    public function getAll(){
    	
    	$clientes = Cliente::orderBy('id')->get();

        //dd($clientes);
    	return view('cliente.listagem',compact('clientes'));
    }

    //Retorna a View de cadastro da cliente
    public function cadastrar(){
        $unidades = Unidade::all('id','localidade');
    	return view('cliente.cadastrar',compact('unidades'));	
    }

    //Cadatra um cliente e redireciona novamente para um tela de cadastro
    public function salvar(Request $request){
    	$cliente =Cliente::create($request->all());

    	\Session::flash('flash_message',[
    		'msg'=>"Cadastro da ".$cliente->nome." realizado com sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"

        ]);

    	return redirect()->route('cliente.getAll');
    }

    //Retorna a View de edição da cliente
    public function editar($id){
    	$cliente = Cliente::find($id);
        $unidades = Unidade::all('id','localidade');
        if(!$cliente){
            \Session::flash('flash_message',[
                'msg'=>"Não existe esse Cliente cadastrado!!! Deseja cadastrar um novo Cliente?",
                'class'=>"alert-danger"
            ]);
            return redirect()->route('cliente.cadastrar');
        }
        return view('cliente.editar',compact('cliente','unidades'));
    }

     //Atualiza um cliente e redireciona para a tela de listagem de clientes
    public function atualizar(Request $request,$id){
        $cliente = Cliente::find($id);
        $cliente->update($request->all());
        
        \Session::flash('flash_message',[
            'msg'=>"Cliente (" .$cliente->nome. ") atualizado com sucesso!!!",
            'class'=>"alert bg-green alert-dismissible"
        ]);
        return redirect()->route('cliente.getAll');    	
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

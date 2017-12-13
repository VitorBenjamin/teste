<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Processo;
use App\Cliente;
class ProcessoController extends Controller
{

	public function getProcesso(Request $search){
		$processos = Processo::where('codigo','like','%'.$search->input('query').'%')
		->select('codigo')
		->get();
		$data = array(); 
		foreach ($processos as $value) {
			$data[] = $value->codigo;
		}
		
		return response()->json($data);
	}
	//Buscando todas as informações dos clientes e enviando para a view de listagem das clientes
	public function getAll(){

		$processos = Processo::orderBy('id')->get();
		$clientes = Cliente::all();
        //dd($processos);
		return view('processo.listagem',compact('processos','clientes'));
	}

    //Cadatra um cliente e redireciona novamente para um tela de cadastro
	public function salvar(Request $request){
		
		$processo = Processo::create($request->all());

		\Session::flash('flash_message',[
			'msg'=>"Cadastro do Processo n° ".$processo->codigo." realizado com sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"

		]);

		return redirect()->route('processo.getAll');
	}

    //Retorna a View de edição da cliente
	public function editar($id){
		$processo = Processo::find($id);
		if(!$processo){
			\Session::flash('flash_message',[
				'msg'=>"Não existe esse Processo cadastrado!!!",
				'class'=>"alert bg-red alert-dismissible"
			]);
			return redirect()->route('cliente.cadastrar');
		}
		return view('processo.getAll',compact('processo'));
	}

    //Atualiza um cliente e redireciona para a tela de listagem de clientes
	public function atualizar(Request $request,$id){
		$processo = Processo::find($id);
		$processo->update($request->all());

		\Session::flash('flash_message',[
			'msg'=>"Processo n° " .$processo->codigo. " atualizado com sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route('processo.getAll');    	
	}

    //Deleta ou Não um cliente e redireciona para a tela de listagem de clientes
	public function deletar($id){
		 
		$processo = Processo::find($id);
		$codigo = $processo->codigo;
		$processo->delete();

		\Session::flash('flash_message',[
			'msg'=>"Processo n° ".$codigo." apagado com sucesso!!!",
			'class'=>"alert bg-red alert-dismissible"
		]);
		return redirect()->route('processo.getAll');    	
	}

}

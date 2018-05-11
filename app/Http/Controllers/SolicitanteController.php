<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitante;
use App\Cliente;
use Illuminate\Support\Facades\DB;

class SolicitanteController extends Controller
{

	public function getSolicitante(Request $data){

		//dd($query);
		$solicitantes = Solicitante::where('clientes_id',$data->data)
		->select('id','nome')
		->get();
		// $solicitantes = Solicitante::where('nome','like','%'.$data->data.'%')
		// ->select('id','nome')
		// ->get();
		// $solicitantes = Solicitante::where('clientes_id', $query->q)
		// ->select('id','nome')
		// ->get();

		return response()->json($solicitantes);
	}

    //Buscando todas as informações dos clientes e enviando para a view de listagem das clientes
	public function getAll(){

		$solicitantes = Solicitante::orderBy('id')->get();
		$clientes = Cliente::all();
        //dd($processos);
		return view('solicitante.listagem',compact('solicitantes','clientes'));
	}
    //Cadatra um cliente e redireciona novamente para um tela de cadastro
	public function salvar(Request $request){
		
		$solicitante = Solicitante::create($request->all());

		\Session::flash('flash_message',[
			'msg'=>"Cadastro dos Solicitante ".$solicitante->nome." realizado com sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		//return redirect()->route('solicitante.getAll');
		return redirect()->back();
	}

    //Retorna a View de edição da cliente
	public function editar($id){
		$solicitante = Solicitante::find($id);
		if(!$solicitante){
			\Session::flash('flash_message',[
				'msg'=>"Não existe esse Solicitante cadastrado!!!",
				'class'=>"alert bg-red alert-dismissible"
			]);
		}
		return view('solicitante.getAll',compact('solicitante'));
	}

    //Atualiza um cliente e redireciona para a tela de listagem de clientes
	public function atualizar(Request $request,$id){
		$solicitante = Solicitante::find($id);
		$solicitante->update($request->all());

		\Session::flash('flash_message',[
			'msg'=>"Solicitante " .$solicitante->nome. " atualizado com sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route('solicitante.getAll');    	
	}

    //Deleta ou Não um cliente e redireciona para a tela de listagem de clientes
	public function deletar($id){

		$solicitante = Solicitante::find($id);
		DB::table('solicitacoes')
            ->where('solicitantes_id', $id)
            ->update(['solicitantes_id' => null]);
		$solicitante->delete();

		\Session::flash('flash_message',[
			'msg'=>"Solicitante ".$solicitante->nome." removido com sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->back();    	
	}
}

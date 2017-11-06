<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use App\Compra;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;


class CompraController extends Controller
{

    //Retorna a View de cadastro da unidade
	public function cadastrar()
	{
		$areas = AreaAtuacao::all('id','tipo');
		return view('compra.cadastrar', compact('areas')); 	
	}

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
	public function salvar(SolicitacaoRequest $request)
	{   
		$repo = new SolicitacaoRepository();
		$solicitacao = $repo->create($request,config('constantes.tipo_compra'));

		\Session::flash('flash_message',[
			'msg'=>"Cadastro do ".$solicitacao->tipo." Realizado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
			]);

		return redirect()->route('compra.editar', $solicitacao->id);
	}

    //Retorna a View de edição da unidade
	public function editar($id)
	{

		$solicitacao = Solicitacao::with('compra')
		->where('tipo',config('constantes.tipo_compra'))
		->where('id',$id)
		->first();
		if(!$solicitacao){
			\Session::flash('flash_message',[
				'msg'=>"Não Existe essa Solicitacao Cadastrada!!! Deseja Cadastrar uma Nova Solicitação?",
				'class'=>"alert bg-red alert-dismissible"
				]);
			return redirect()->route('compra.cadastrar');            
		}
		$cliente = Cliente::where('id',$solicitacao->clientes_id)->select('id','nome')->get();
		$areas = AreaAtuacao::all('id','tipo'); 
		$solicitante = Solicitante::where('id',$solicitacao->solicitantes_id)->select('id','nome')->get();

		return view('compra.editar', compact('solicitacao','cliente','areas','solicitante'));
	}

    //Atualiza uma compra e redireciona para a tela de edição da Solicitação
	public function atualizarCompra(Request $request,$id)
	{   
		$compra = Compra::find($id);

		$compra->update(
			[   
			'descricao' => $request->descricao,
			'data_compra' => $request->data_compra,
			'quantidade' => $request->quantidade,                
			]
			);

		\Session::flash('flash_message',[
			'msg'=>"Compra Atualizada com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
			]);
		return redirect()->route('compra.editar', $compra->solicitacoes_id);
	}
	public function addCompra(Request $request,$id){
		Compra::create([
			'data_compra' => $request->data_compra,
			'descricao' => $request->descricao,
			'quantidade' => $request->quantidade,
			'solicitacoes_id' => $id,
			]);
		\Session::flash('flash_message',[
			'msg'=>"Produto Cadastrado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
			]);
		return redirect()->route('compra.editar',$id);
	}
	//Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
	public function deletarCompra($id)
	{        

		$translado = Compra::find($id);
		$s_id = $translado->solicitacoes_id;
		$translado->delete();
		\Session::flash('flash_message',[
			'msg'=>"Compra Removida com Sucesso!!!",
			'class'=>"alert bg-red alert-dismissible"
			]);
		return redirect()->route('compra.editar',$s_id);       
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
		return redirect()->route('compra.editar',$id);
	}


}

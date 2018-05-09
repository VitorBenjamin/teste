<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SolicitacaoHelper;
use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use App\Compra;
use App\Processo;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao;
use App\Status;
use App\Cotacao;


class CompraController extends Controller
{

    //Retorna a View de cadastro da unidade
	public function cadastrar()
	{
		$areas = AreaAtuacao::all('id','tipo');
		$processos = Processo::all();
		$clientes = Cliente::all('id','nome');
		$solicitantes = Solicitante::all('id','nome');
		return view('compra.cadastrar', compact('areas','processos','clientes','solicitantes'));  	
	}

    //Cadatra uma nova Solicitação e redireciona para a tela de edição
	public function salvar(SolicitacaoRequest $request)
	{   
		$repo = new SolicitacaoRepository();
		$solicitacao = $repo->create($request,config('constantes.tipo_compra'));

		\Session::flash('flash_message',[
			'msg'=>"Compra Cadastrada com Sucesso. Adicione um produto!",
			'class'=>"alert bg-green alert-dismissible"
		]);

		return redirect()->route('compra.editar', $solicitacao->id);
	}
	
	public function verificarSolicitacao($id)
	{
		$solicitacao = Solicitacao::with('compra')
		->where('tipo',config('constantes.tipo_compra'))
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

	public function analisar($id)
	{

		$solicitacao = Solicitacao::with('compra','cliente','solicitante','processo','area_atuacao')->where('id',$id)->first();
		if ($solicitacao == null) {
			\Session::flash('flash_message',[
				'msg'=>"Solicitação não cadastrada!",
				'class'=>"alert bg-yellow alert-dismissible"
			]);
			return redirect()->route('user.index'); 
		}
		return view('compra.analiseCompra', compact('solicitacao'));

	}

    //Retorna a View de edição da unidade
	public function editar($soli)
	{
		$solicitacao = $soli;
		//$cliente = Cliente::where('id',$solicitacao->clientes_id)->select('id','nome')->get();
		$areas = AreaAtuacao::all('id','tipo'); 
		//$solicitante = Solicitante::where('id',$solicitacao->solicitantes_id)->select('id','nome')->get();
		$clientes = Cliente::all('id','nome');
		//$solicitantes = Solicitante::all('id','nome');
		return view('compra.editar', compact('solicitacao','clientes','areas'));
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
	public function aprovarCotacao($compraId,$cotacaoId)
	{
		$cotacoes = Cotacao::where('compras_id',$compraId)->get();
		foreach ($cotacoes as $cota) {
			if ($cota->id == $cotacaoId) {
				
				$cota->aprovado = 1;
				$cota->save();
			}else{
				$cota->aprovado = 0;
				$cota->save();
			}
		}
		\Session::flash('flash_message',[
			'msg'=>"Compravente Cadastrado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->back();
	}
	public function addCotacao(Request $request,$id)
	{
		//dd($request->all());
		foreach ($request->data_cotacao as $key => $value) {
			//dd($request->valor[$key]);
			// $cotacao = Cotacao::create([
			// 	'descricao' => $request->descricao[$key],
			// 	'data_cotacao' => date('Y-m-d', strtotime($request->data_cotacao[$key])),
			// 	'fornecedor' => $request->fornecedor[$key],
			// 	'quantidade' => $request->quantidade[$key],
			// 	'valor' => $request->valor[$key],
			// 	'anexo_comprovante' => $request->anexo_comprovante[$key], 
			// 	'compras_id' => $request->compras_id,
			// ]);
			//dd( $request->file('anexo_comprovante')[$key]);
			//dd(floatval($request->valor[$key]));
			$data = [
				'descricao' => $request->descricao[$key],
				'data_cotacao' => date('Y-m-d', strtotime($request->data_cotacao[$key])),
				'fornecedor' => $request->fornecedor[$key],
				'quantidade' => $request->quantidade[$key],
				'valor' => $request->valor[$key],
				'compras_id' => $request->compras_id,
			];
			// if ($request->file('anexo_comprovante')[$key]) {

			// 	$mime = $request->file('anexo_comprovante')[$key]->getClientMimeType();
			// 	$data['solicitacoes_id'] = $id;
			// 	if ($mime == "image/jpeg" || $mime == "image/png") {
			// 		$file = Image::make($request->file('anexo_comprovante')[$key]);
			// 		$img_64 = (string) $file->encode('data-url');
			// 		$data['anexo_comprovante'] = $img_64;
			// 	}elseif ($mime == "application/pdf") {
			// 		$today = (string) date("Y-m-d");
			// 		$fileName = $today.'_'.$id.'_'.$request->file('anexo_comprovante')[$key]->getClientOriginalName();    
			// 		$request->anexo_comprovante[$key]->storeAs('public/cotacoes',$fileName);
			// 		$data['anexo_pdf'] = $fileName;
			// 	}else{

			// 		Session::flash('flash_message',[
			// 			'msg'=>"Arquivo não suportado!!!",
			// 			'class'=>"alert bg-orange alert-dismissible"
			// 		]);
			// 		return redirect()->back();
			// 	}
			// }
			
			$cotacao = Cotacao::create($data);
			//dd($cotacao);
		}
		\Session::flash('flash_message',[
			'msg'=>"Cotações Cadastradas com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		
		return redirect()->back();
	}
	public function addComprovante(Request $request,$id){
		$cotacoes = Cotacao::where('compras_id',$id)->get();
		
		foreach ($cotacoes as $cota) {
			if ($cota->aprovado) {
				if ($request->file('anexo_comprovante')) {
					$mime = $request->file('anexo_comprovante')->getClientMimeType();
					if ($mime == "image/jpeg" || $mime == "image/png") {
						$file = Image::make($request->file('anexo_comprovante'));
						$img_64 = (string) $file->encode('data-url');
						$cota->anexo_comprovante = $img_64;
					}
				}
				$cota->data_compra = $request->data_compra;
				$cota->save();
			}else{
				$cota->data_compra = null;
				$cota->anexo_comprovante = null;
				$cota->save();
			}
		}
		\Session::flash('flash_message',[
			'msg'=>"Comprovante Cadastrado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->back();
	}

	public function addCompra(Request $request,$id){
		Compra::create([
			'data_compra' => date('Y-m-d', strtotime($request->data_compra)),
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
	public function deletarCotacao($id)
	{
		$cotacao = Cotacao::find($id);
		$cotacao->delete();
		\Session::flash('flash_message',[
			'msg'=>"Cotação Removida com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->back();
	}
	//Deleta ou Não uma unidade e redireciona para a tela de listagem de solicitacao
	public function deletarCompra($id)
	{        

		$Compra = Compra::find($id);
		$s_id = $Compra->solicitacoes_id;
		$Compra->delete();
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

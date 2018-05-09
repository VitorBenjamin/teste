<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SolicitacaoHelper;
use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Comentario;
use App\User;
use App\Cotacao;
use App\Comprovante;
use App\Despesa;
use App\Processo;
use App\Translado;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao; 
use App\Status;
use PDF;
class SolicitacaoController extends Controller
{
    //Buscando todas as informações das solicitacao e enviando para a view de listagem das solicitacao
	public function print($id)
	{
		$lista = array();
		$solicitacaoHelper = new SolicitacaoHelper();
		$solicitacao = Solicitacao::find($id);
		$lista = $solicitacaoHelper->impressao($solicitacao,$lista);
		usort($lista, function($a, $b) {
			return $a['data'] <=> $b['data'];
		});
        //dd($lista);
		$nome = $solicitacao->cliente ? $solicitacao->cliente->nome : 'Mosello Lima';
		$pdf = PDF::loadView('layouts._includes.impressao.impressao',compact('solicitacao','lista'));
		return $pdf->download('Relátorio '.$nome.'.pdf');
		//return view('layouts._includes.impressao.impressao', compact('solicitacao','lista'));
	}

    //Atualiza uma unidade e redireciona para a tela de listagem de solicitacao
	public function atualizarCabecalho(Request $request,$id)
	{   
		$repo = new SolicitacaoRepository();
		$solicitacao = $repo->update($request,$id);
		$solicitacao = Solicitacao::where('id',$id)->first();
		
		\Session::flash('flash_message',[
			'msg'=>"Solicitação Atualizada com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->route(strtolower($solicitacao->tipo == 'ANTECIPAÇÃO' ? 'antecipacao' : $solicitacao->tipo).'.editar', $id);
	}
	public function getSolicitacao(Request $request)
	{
		//dd($request->all());
		$solicitacoes = null;
		$solicitacao = null;
		if ($request->codigo) {
			$solicitacao = Solicitacao::where('codigo',$request->codigo)->first();
			if (!$solicitacao) {
				\Session::flash('flash_message',[
					'msg'=>"Solicitação não encotrada",
					'class'=>"alert bg-orange alert-dismissible"
				]);
				return redirect()->back();
			}
			return view('layouts._includes.solicitacoes.resultado',compact('solicitacoes','solicitacao'));
		}
		if ($request->area_atuacoes_id) {
			$solicitacoes = Solicitacao::where('clientes_id',$request->clientes_id)
			->where('users_id',$request->advogados_id)
			->where('area_atuacoes_id',$request->area_atuacoes_id)->get();
			if (!$solicitacoes) {
				\Session::flash('flash_message',[
					'msg'=>"Solicitação não encotrada",
					'class'=>"alert bg-orange alert-dismissible"
				]);
				return redirect()->back();
			}
			return view('layouts._includes.solicitacoes.resultado',compact('solicitacoes','solicitacao'));
		}

		$solicitacoes = Solicitacao::where('clientes_id',$request->clientes_id)
		->where('users_id',$request->advogados_id)->get();
		//dd($solicitacoes);
		return view('layouts._includes.solicitacoes.resultado',compact('solicitacoes','solicitacao'));
	}
	public function getSolicitacaoView()
	{
		$areas = AreaAtuacao::all('id','tipo'); 
		$advogados = User::all('id','nome');
		$clientes = Cliente::all('id','nome');
		$solicitantes = Solicitante::all('id','nome');
		return view('layouts._includes.solicitacoes.get_solitacoes', compact('areas','advogados','solicitantes','clientes'));
	}
	public function addComprovante(Request $request,$id)
	{
		//dd($request->all());
		$solicitacao = Solicitacao::where('id',$id)->first();
		$data = [
			'data' => date('Y-m-d', strtotime($request->data)),
			'solicitacoes_id' => $id,
		];
		$mime = $request->file('anexo')->getClientMimeType();
		if ($mime == "image/jpeg" || $mime == "image/png") {
			$file = Image::make($request->file('anexo'));
			$img_64 = (string) $file->encode('data-url');
			$data['anexo'] = $img_64;
		}else{

			\Session::flash('flash_message',[
				'msg'=>"Arquivo não suportado!!!",
				'class'=>"alert bg-orange alert-dismissible"
			]);
			return redirect()->back();
		}
		Comprovante::create($data);
		
		\Session::flash('flash_message',[
			'msg'=>"Comprovante Adicionado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->back();
	}
	public function editComprovante(Request $request,$id)
	{
		$solicitacao = Solicitacao::where('id',$id)->first();
		$comprovante = Comprovante::find($request->comprovante_id);
		$data = [
			'data' => date('Y-m-d', strtotime($request->data)),
			'solicitacoes_id' => $comprovante->solicitacoes_id,
		];
		if ($request->hasFile('anexo')) {
			$mime = $request->file('anexo')->getClientMimeType();
			if ($mime == "image/jpeg" || $mime == "image/png") {
				$file = Image::make($request->file('anexo'));
				$img_64 = (string) $file->encode('data-url');
				$data['anexo'] = $img_64;
			}else{

				\Session::flash('flash_message',[
					'msg'=>"Arquivo não suportado!!!",
					'class'=>"alert bg-orange alert-dismissible"
				]);
				return redirect()->back();
			}
		}else{
			if ($comprovante->anexo) {
				$data['anexo'] = $comprovante->anexo;
			}
		}
		$comprovante->update($data);
		\Session::flash('flash_message',[
			'msg'=>"Comprovante Adicionado com Sucesso!!!",
			'class'=>"alert bg-green alert-dismissible"
		]);
		return redirect()->back();
	}

	public function andamento($id)
	{
		$solicitacao = Solicitacao::find($id);
		$status = $solicitacao->status[0]->descricao;
		$repo = new SolicitacaoRepository();
		$limites = auth()->user()->limites;
		if ($status == config('constantes.status_devolvido')) 
		{
			if ($solicitacao->tipo == "COMPRA" || $solicitacao->tipo == "VIAGEM"){
				$andamento = Status::where('descricao', config('constantes.status_recorrente_financeiro'))->first();
			}else{
				$andamento = Status::where('descricao', config('constantes.status_andamento_recorrente'))->first();
			}
		}elseif ($status == "ABERTO-ETAPA2" || $status == config('constantes.status_devolvido_etapa2')) {

			if (Auth::user()->hasRole(config('constantes.user_coordenador'))) {
				if (!$repo->verificaLimite($solicitacao,$limites)) {
					$andamento = Status::where('descricao', config('constantes.status_andamento_etapa2'))->first();
				}else{
					$andamento = Status::where('descricao', config('constantes.status_aprovado_etapa2'))->first();
				}
			} else {
				$andamento = Status::where('descricao', config('constantes.status_andamento_etapa2'))->first();
			}
		}elseif (($solicitacao->tipo == "COMPRA" || $solicitacao->tipo == "VIAGEM") && (($status != config('constantes.status_aberto_etapa2') && $status != config('constantes.status_devolvido_etapa2')) || ($status != config('constantes.status_devolvido')))){
			if ($status == config('constantes.status_andamento_administrativo')) {
				
				$andamento = Status::where('descricao', config('constantes.status_andamento'))->first();

			}elseif ($status == config('constantes.status_recorrente_financeiro')) {
				$andamento = Status::where('descricao',config('constantes.status_andamento_recorrente'))->first();
			}else{
				if (auth()->user()->administrativo) {
					$andamento = Status::where('descricao', config('constantes.status_andamento'))->first();
				}else{
					$andamento = Status::where('descricao', config('constantes.status_andamento_administrativo'))->first();
				}
			}
		}else {
			if (Auth::user()->hasRole(config('constantes.user_coordenador'))) {
				if (!$repo->verificaLimite($solicitacao,$limites)) {
					$andamento = Status::where('descricao', config('constantes.status_andamento'))->first();
				}else{
					$andamento = Status::where('descricao', config('constantes.status_aprovado'))->first();
				}
			} else {
				$andamento = Status::where('descricao', config('constantes.status_andamento'))->first();
			}
		}
		$this->trocarStatus($solicitacao,$andamento);

		return redirect()->route('user.index');
	}

	public function aprovar($id)
	{

		$solicitacao = Solicitacao::find($id);
		$status = $solicitacao->status[0]->descricao;
		if ($status == config('constantes.status_andamento_etapa2')) { 

			$aprovado = Status::where('descricao', config('constantes.status_aprovado_etapa2'))->first();

		} elseif ($status == config('constantes.status_devolvido_financeiro')) {

			$aprovado = Status::where('descricao', config('constantes.status_aprovado_recorrente'))->first();

		} elseif ($status == config('constantes.status_aberto_financeiro')) {

			$aprovado = Status::where('descricao', config('constantes.status_andamento_financeiro'))->first();

		} else {			

			$aprovado = Status::where('descricao', config('constantes.status_aprovado'))->first();
		}
		$this->trocarStatus($solicitacao,$aprovado);
		$solicitacao->aprovador_id = auth()->user()->id;
		$solicitacao->save();
		return redirect()->route('user.index');

	}

	public function devolver(Request $request, $id)
	{

		$solicitacao = Solicitacao::find($id);
		$status = $solicitacao->status[0]->descricao;
		$data = 
		[
			'comentario' => $request->comentario,
			'solicitacoes_id' => $id,
			'users_id' => Auth::user()->id,
			'status' => "DEVOLVIDO",
		];
		if ($solicitacao->tipo == "COMPRA" || $solicitacao->tipo == "VIAGEM"){

			if ($status == config('constantes.status_andamento_administrativo') || $status == config('constantes.status_recorrente_financeiro')) {

				$devolvido = Status::where('descricao', config('constantes.status_devolvido'))->first();
				$data['publico'] = true;
			} elseif($status == config('constantes.status_andamento') || $status == config('constantes.status_andamento_recorrente')){

				$devolvido = Status::where('descricao', config('constantes.status_recorrente_financeiro'))->first();
				$data['publico'] = false;
			}elseif ($status == "ANDAMENTO-ETAPA2") {

				$devolvido = Status::where('descricao', config('constantes.status_aberto_etapa2'))->first();
				$data['publico'] = true;

			}
		} elseif ($status == config('constantes.status_coordenador_aprovado')) {

			$devolvido = Status::where('descricao', config('constantes.status_coordenador_aberto'))->first();
			$data['publico'] = false;

		} elseif ($status == config('constantes.status_coordenador_aprovado2')) {

			$devolvido = Status::where('descricao', config('constantes.status_coordenador_aberto2'))->first();
			$data['publico'] = false;
		} elseif ($status == config('constantes.status_andamento_financeiro')) {

			if (Auth::user()->hasRole(config('constantes.user_coordenador'))) {

				$devolvido = Status::where('descricao', config('constantes.status_recorrente_financeiro'))->first();
				$data['publico'] = false;
			}

		} elseif($status == config('constantes.status_andamento_etapa2')) {
			$devolvido = Status::where('descricao', config('constantes.status_devolvido_etapa2'))->first();
			$data['publico'] = true;

		} elseif (Auth::user()->hasRole(config('constantes.user_financeiro')) || Auth::user()->hasRole(config('constantes.user_administrativo'))) {

			$devolvido = Status::where('descricao', config('constantes.status_recorrente'))->first();
			$data['publico'] = false;
		} else {

			$devolvido = Status::where('descricao', config('constantes.status_devolvido'))->first();
			$data['publico'] = true;
		}
		Comentario::create($data);
		$this->trocarStatus($solicitacao,$devolvido);
		return redirect()->route('user.index');
	}

	public function reprovar($id)
	{
		$solicitacao = Solicitacao::find($id);
		$status = $solicitacao->status[0]->descricao;
		$reprovado = Status::where('descricao', config('constantes.status_reprovado'))->first();				
		$this->trocarStatus($solicitacao,$reprovado);
		return redirect()->route('user.index');
	}

	public function finalizar($id)
	{
		$solicitacao = Solicitacao::find($id);
		$status = $solicitacao->status[0]->descricao;
		//dd($solicitacao->tipo);

		if ($status == config('constantes.status_aprovado_etapa2') || $status == config('constantes.status_coordenador_aprovado2')) {

			if($solicitacao->tipo == "COMPRA"){
				$this->setDataCotacao($solicitacao);
			}
			$finalizar = Status::where('descricao', config('constantes.status_finalizado'))->first();
			$solicitacao->data_finalizado = date("Y-m-d");
			$solicitacao->save();

		}elseif ($solicitacao->tipo == "VIAGEM" || $solicitacao->tipo == "ANTECIPAÇÃO" ) {			
			
			if ($status == config('constantes.status_coordenador_aprovado')) {
				$finalizar = Status::where('descricao', config('constantes.status_coordenador_aberto2'))->first();

			} elseif ($solicitacao->tipo == "ANTECIPAÇÃO" && $status == config('constantes.status_aberto_etapa2')) {
				dd($solicitacao->tipo);
				$finalizar = Status::where('descricao', config('constantes.status_finalizado'))->first();
				$this->trocarStatus($solicitacao,$finalizar);
				return redirect()->route('user.index');
				// return back();
			} else {
				$finalizar = Status::where('descricao', config('constantes.status_aberto_etapa2'))->first();
			}

		}else{
			if($solicitacao->tipo == "COMPRA"){
				$this->setDataCotacao($solicitacao);
			}
			$finalizar = Status::where('descricao', config('constantes.status_finalizado'))->first();	
			$solicitacao->data_finalizado = date("Y-m-d");
			$solicitacao->save();			
		}
		$this->trocarStatus($solicitacao,$finalizar);
		// return redirect()->route('user.index');
		return back();
	}
	public function setDataCotacao($solicitacao)
	{ 
		//dd($solicitacao->compra[0]->cotacao);
		if ($solicitacao->compra != null ) {
			foreach ($solicitacao->compra as $compra) {
				if (count($compra->cotacao) >0) {
					$menor = $compra->cotacao[0]->valor;

					foreach ($compra->cotacao as $key => $cotacao) {
						//dd($cotacao);
						if ($key == 0) {
							$cota = $cotacao->id;
						} 
						if ($cotacao->valor < $menor) {
							$menor = $cotacao->valor;
							$cota = $cotacao->id;

						}else{
							$cotacao->data_compra = null;
							$cotacao->save();
						}
					}
					$contacoes = Cotacao::find($cota);
					$contacoes->data_compra=date("Y-m-d");
					$contacoes->save();
				}
			}
		}
	}
	public function trocarStatus($solicitacao,$proximo)
	{
		$atual = $solicitacao->status;
		$solicitacao->status()->detach($atual);
		$solicitacao->status()->attach($proximo);
	}

	public function deletarAdmin(Request $request)
	{
		$solicitacao = Solicitacao::where('id',$request->id)->first();
		$tipo = $solicitacao->tipo;
		if ($solicitacao->delete()) {
			\Session::flash('flash_message',[
				'msg'=> $tipo. " Removido com Sucesso!!!",
				'class'=>"alert bg-red alert-dismicssible"
			]);
			return route('solicitacao.getSolicitacaoView');
		}else{
			\Session::flash('flash_message',[
				'msg'=>"Solicitação não pode ser removida.",
				'class'=>"alert bg-red alert-dismissible"

			]);
			return response()->json([
				'success' => false,
				'message' => $errors
			], 422);
		}
		return route('user.index');
	}
	public function deletar(Request $request)
	{
		$solicitacao = Solicitacao::where('id',$request->id)->with('status')->first();
		foreach ($solicitacao->status as $status) 
		{

			if ($status->descricao == config('constantes.status_aberto') || $status->descricao == config('constantes.status_devolvido') || $status->descricao == config('constantes.status_andamento') || $status->descricao == config('constantes.status_andamento_administrativo') || $status->descricao == config('constantes.status_andamento_recorrente')) {

				$tipo = $solicitacao->tipo;
				if ($solicitacao->delete()) {
					\Session::flash('flash_message',[
						'msg'=> $tipo. " Removido com Sucesso!!!",
						'class'=>"alert bg-red alert-dismicssible"
					]);
					return route('user.index');
				}
			}else {

				\Session::flash('flash_message',[
					'msg'=>"Solicitação não pode ser removida.",
					'class'=>"alert bg-red alert-dismissible"

				]);

				return response()->json([
					'success' => false,
					'message' => $errors
				], 422);
			}   
		}
		return route('user.index');
	}
}

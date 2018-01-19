<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Comentario;
use App\Comprovante;
use App\Despesa;
use App\Processo;
use App\Translado;
use App\Solicitacao;
use App\Solicitante;
use App\Cliente;
use App\AreaAtuacao; 
use App\Status;

class SolicitacaoController extends Controller
{
    //Buscando todas as informações das solicitacao e enviando para a view de listagem das solicitacao
	public function index()
	{
		
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
	public function addComprovante(Request $request,$id)
	{
		//dd($request->all());
		$solicitacao = Solicitacao::where('id',$id)->first();
		$data = [
			'data' => date('Y-m-d', strtotime($request->data)),
			'solicitacoes_id' => $id,
		];
		$mime = $request->file('anexo_comprovante')->getClientMimeType();
		if ($mime == "image/jpeg" || $mime == "image/png") {
			$file = Image::make($request->file('anexo_comprovante'));
			$img_64 = (string) $file->encode('data-url');
			$data['anexo_comprovante'] = $img_64;
		}elseif ($mime == "application/pdf") {
			$today = (string) date("Y-m-d");
			$fileName = $today.'_'.$id.'_'.$request->anexo_comprovante->getClientOriginalName();    
			$request->anexo_comprovante->storeAs('public/comprovante',$fileName);
			$data['anexo_pdf'] = $fileName;
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
		//dd($request->all());
		$solicitacao = Solicitacao::where('id',$id)->first();
		$comprovante = Comprovante::find($request->comprovante_id);
		//dd($comprovante);
		$data = [
			'data' => date('Y-m-d', strtotime($request->data)),
			'solicitacoes_id' => $request->$id,
		];
		//dd($request->all());
		if ($request->hasFile('anexo_comprovante')) {
			$mime = $request->file('anexo_comprovante')->getClientMimeType();
			//dd($mime);
			if ($mime == "image/jpeg" || $mime == "image/png") {
				$file = Image::make($request->file('anexo_comprovante'));
				$img_64 = (string) $file->encode('data-url');
				$data['anexo_comprovante'] = $img_64;
				if ($comprovante->anexo_pdf) {
					Storage::delete('/public/comprovante/'. $comprovante->anexo_pdf);
					$data['anexo_pdf'] = null;
				}
			}elseif ($mime == "application/pdf") {
				$today = (string) date("Y-m-d");
				$fileName = $today.'_'.$id.'_'.$request->anexo_comprovante->getClientOriginalName();    
				$request->anexo_comprovante->storeAs('public/comprovante',$fileName);
				$data['anexo_pdf'] = $fileName;
				if ($comprovante->anexo_pdf) {
					Storage::delete('/public/comprovante/'. $comprovante->anexo_pdf);
					$data['anexo_pdf'] = null;
				}
				if ($comprovante->anexo_comprovante) {
					$data['anexo_comprovante'] = null;
				}
			}else{

				\Session::flash('flash_message',[
					'msg'=>"Arquivo não suportado!!!",
					'class'=>"alert bg-orange alert-dismissible"
				]);
				return redirect()->back();
			}
		}else{
			if ($comprovante->anexo_comprovante) {
				$data['anexo_comprovante'] = $comprovante->anexo_comprovante;
			} else {
				$data['anexo_pdf'] = $comprovante->anexo_pdf;
			}
		}
		//dd($data);
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
			$andamento = Status::where('descricao', config('constantes.status_andamento_recorrente'))->first();

		}elseif ($solicitacao->tipo == "COMPRA"){

			if ($status == config('constantes.status_andamento_administrativo')) {
				$andamento = Status::where('descricao', config('constantes.status_andamento'))->first();
			}elseif ($status == config('constantes.status_recorrente_financeiro')) {

				$andamento = Status::where('descricao',config('constantes.status_andamento_recorrente'))->first();
			}else{

				$andamento = Status::where('descricao', config('constantes.status_andamento_administrativo'))->first();

			}

		} elseif ($status == "ABERTO-ETAPA2" || $status == config('constantes.status_devolvido_etapa2')) {

			if (Auth::user()->hasRole(config('constantes.user_coordenador'))) {
				if (!$repo->verificaLimite($solicitacao,$limites)) {
					$andamento = Status::where('descricao', config('constantes.status_andamento_etapa2'))->first();
				}else{
					$andamento = Status::where('descricao', config('constantes.status_aprovado_etapa2'))->first();
				}
			} else {
				$andamento = Status::where('descricao', config('constantes.status_andamento_etapa2'))->first();
			}
		} else {			

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
		if ($solicitacao->tipo == "COMPRA"){

			if ($status == config('constantes.status_andamento_administrativo') || $status == config('constantes.status_recorrente_financeiro')) {

				$devolvido = Status::where('descricao', config('constantes.status_devolvido'))->first();
				$data['publico'] = true;
			}elseif($status == config('constantes.status_andamento') || $status == config('constantes.status_andamento_recorrente')){

				$devolvido = Status::where('descricao', config('constantes.status_recorrente_financeiro'))->first();
				$data['publico'] = false;

			}

		}elseif ($status == config('constantes.status_coordenador_aprovado')) {

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
		if ($status == config('constantes.status_aprovado_etapa2') || $status == config('constantes.status_coordenador_aprovado2')) {
			$finalizar = Status::where('descricao', config('constantes.status_finalizado'))->first();
			$solicitacao->data_finalizado = date("Y-m-d");
			$solicitacao->save();
		}elseif ($solicitacao->tipo == "VIAGEM" || $solicitacao->tipo == "ANTECIPAÇÃO" ) {			
			if ($status == config('constantes.status_coordenador_aprovado')) {
				$finalizar = Status::where('descricao', config('constantes.status_coordenador_aberto2'))->first();
			} else {
				$finalizar = Status::where('descricao', config('constantes.status_aberto_etapa2'))->first();
			}


		}else{
			$finalizar = Status::where('descricao', config('constantes.status_finalizado'))->first();	
			$solicitacao->data_finalizado = date("Y-m-d");
			$solicitacao->save();			
		}
		$this->trocarStatus($solicitacao,$finalizar);
		return redirect()->route('user.index');
	}

	public function trocarStatus($solicitacao,$proximo)
	{
		//$solicitacao = Solicitacao::find($id);
		$atual = $solicitacao->status;
		//dd($atual);
		$solicitacao->status()->detach($atual);
		$solicitacao->status()->attach($proximo);
	}

	public function deletar(Request $request)
	{
        //echo "asdasdasdasdasd";
		$solicitacao = Solicitacao::where('id',$request->id)->with('status')->first();
		foreach ($solicitacao->status as $status) 
		{

			if ($status->descricao == config('constantes.status_aberto') || $status->descricao == config('constantes.status_devolvido')) {

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

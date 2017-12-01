<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use Illuminate\Support\Facades\Auth;
use App\Comentario;
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

	public function andamento($id)
	{

		$solicitacao = Solicitacao::find($id);
		$status = $solicitacao->status[0]->descricao;
		$status = $solicitacao->status[0]->descricao;
		
		if ($status == config('constantes.status_devolvido')) 
		{
			$andamento = Status::where('descricao', config('constantes.status_andamento_recorrente'))->first();

		} elseif ($status == config('constantes.status_coordenador_aberto')) {
			
			$andamento = Status::where('descricao', config('constantes.status_coordenador_aprovado'))->first();

		} elseif ($status == config('constantes.status_coordenador_aberto2')) {
			
			$andamento = Status::where('descricao', config('constantes.status_coordenador_aprovado2'))->first();

		} elseif($solicitacao->tipo == "COMPRA"){
			
			$andamento = Status::where('descricao', config('constantes.status_andamento_financeiro'))->first();

		} elseif ($status == "ABERTO-ETAPA2" || $status == config('constantes.status_devolvido_etapa2')) {

			$andamento = Status::where('descricao', config('constantes.status_andamento_etapa2'))->first();

		} else {			
			
			$andamento = Status::where('descricao', config('constantes.status_andamento'))->first();

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

		}elseif($status == config('constantes.status_aberto_financeiro')){
			
			$aprovado = Status::where('descricao', config('constantes.status_andamento_financeiro'))->first();

		}else {			

			$aprovado = Status::where('descricao', config('constantes.status_aprovado'))->first();
		}
		$this->trocarStatus($solicitacao,$aprovado);

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
		if ($status == config('constantes.status_coordenador_aprovado')) {
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

		} elseif (Auth::user()->hasRole(config('constantes.user_financeiro'))) {
			
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

	public function finalizar($id)
	{
		$solicitacao = Solicitacao::find($id);
		$status = $solicitacao->status[0]->descricao;
		if ($status == config('constantes.status_aprovado_etapa2') || $status == config('constantes.status_coordenador_aprovado2')) {
			$finalizar = Status::where('descricao', config('constantes.status_finalizado'))->first();
		}elseif ($solicitacao->tipo == "VIAGEM" || $solicitacao->tipo == "ANTECIPAÇÂO" ) {			
			if ($status == config('constantes.status_coordenador_aprovado')) {
				$finalizar = Status::where('descricao', config('constantes.status_coordenador_aberto2'))->first();
			} else {
				$finalizar = Status::where('descricao', config('constantes.status_aberto_etapa2'))->first();
			}
			
			
		}else{
			$finalizar = Status::where('descricao', config('constantes.status_finalizado'))->first();				
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
						'msg'=> $tipo. "Removido com Sucesso!!!",
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

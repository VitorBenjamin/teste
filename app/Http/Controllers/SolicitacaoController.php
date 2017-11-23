<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use Illuminate\Support\Facades\Auth;
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

	public function andamento($id)
	{

		$solicitacao = Solicitacao::find($id);
		if ($solicitacao->status[0]->descricao == config('constantes.status_devolvido')) {
			$andamento = Status::where('descricao', config('constantes.status_recorrente'))->first();
		}else{
			$andamento = Status::where('descricao', config('constantes.status_andamento'))->first();
		}
		$this->trocarStatus($id,$andamento);
		return redirect()->route('user.index');
	}

	public function aprovar($id)
	{

		$solicitacao = Solicitacao::find($id);
		if ($solicitacao->status[0]->descricao == config('constantes.status_devolvido_financeiro')) {
			
			$aprovado = Status::where('descricao', config('constantes.status_aprovado_recorrente'))->first();
		}else{
			
			$aprovado = Status::where('descricao', config('constantes.status_aprovado'))->first();
		}
		$this->trocarStatus($id,$aprovado);
		return redirect()->route('user.index');

	}	

	public function reprovar($id)
	{
		
		$reprovado = Status::where('descricao', config('constantes.status_reprovado'))->first();				
		$this->trocarStatus($id,$reprovado);
		return redirect()->route('user.index');
	}
	
	public function devolver($id)
	{
		//$andamento = Status::where('descricao', config('constantes.status_andamento'))->first();
		//dd($id);
		if (Auth::user()->hasRole(config('constantes.user_financeiro'))) {
			$devolvido = Status::where('descricao', config('constantes.status_devolvido_financeiro'))->first();
		}else{
			$devolvido = Status::where('descricao', config('constantes.status_devolvido'))->first();
		}
		$this->trocarStatus($id,$devolvido);
		return redirect()->route('user.index');
	}

	public function finalizar($id)
	{
		//$andamento = Status::where('descricao', config('constantes.status_andamento'))->first();
		$devolvido = Status::where('descricao', config('constantes.status_finalizado'))->first();				
		$this->trocarStatus($id,$devolvido);
		return redirect()->route('user.index');
	}

	public function trocarStatus($id,$proximo)
	{
		$solicitacao = Solicitacao::find($id);
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

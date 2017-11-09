<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
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

		$repo = new SolicitacaoRepository();
		$abertas = $repo->getSolicitacao(config('constantes.status_aberto'));
		$andamentos = $repo->getSolicitacao(config('constantes.status_andamento'));
		$aprovadas = $repo->getSolicitacao(config('constantes.status_aprovado'));
		$reprovados = $repo->getSolicitacao(config('constantes.status_reprovado'));
		$devolvidas = $repo->getSolicitacao(config('constantes.status_devolvido'));

		return view('dashboard.index',compact('abertas','andamentos','aprovadas','reprovados','devolvidas'));
	}

	public function andamento($id)
	{
		$aberto = Status::where('descricao',config('constantes.status_aberto'))->first();
		$andamento = Status::where('descricao',config('constantes.status_andamento'))->first();
		$solicitacao = Solicitacao::find($id);		
		$solicitacao->status()->detach($aberto);
		$solicitacao->status()->attach($andamento);
		return redirect()->route('solicitacao.index');

	}
}

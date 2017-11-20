<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Repositories\SolicitacaoRepository;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{


	public function index()
	{
		//dd(Auth::user()->limites[0]->unidades);
		//dd(Auth::user()->hasRole(config('constantes.user_advogado')));
		if (Auth::user()->hasRole(config('constantes.user_advogado'))) {
			//dd(Auth::user()->hasRole(config('constantes.user_advogado')));
			//return $this->advogadoDash();
			return redirect()->route('user.advogadoDash');
		} elseif (Auth::user()->hasRole(config('constantes.user_coordenador'))) {
			
			//return $this->coordenadorDash();
			return redirect()->route('user.coordenadorDash');
		} elseif (Auth::user()->hasRole(config('constantes.user_financeiro'))) {
			
			//return $this->coordenadorDash();
			return redirect()->route('user.financeiroDash');
		}
		
		
	}

	public function advogadoDash()
	{
		$repo = new SolicitacaoRepository();
		
		$abertas = $repo->getSolicitacaoAdvogado(config('constantes.status_aberto'));
		$andamentos = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento'));
		$aprovadas = $repo->getSolicitacaoAdvogado(config('constantes.status_aprovado'));
		$reprovados = $repo->getSolicitacaoAdvogado(config('constantes.status_reprovado'));
		$devolvidas = $repo->getSolicitacaoAdvogado(config('constantes.status_devolvido'));

		$abertas = $repo->valorTotalAdvogado($abertas);
		$andamentos = $repo->valorTotalAdvogado($andamentos);
		$aprovadas = $repo->valorTotalAdvogado($aprovadas);
		$reprovados = $repo->valorTotalAdvogado($reprovados);
		$devolvidas = $repo->valorTotalAdvogado($devolvidas);

		return view('dashboard.advogado',compact('abertas','andamentos','aprovadas','reprovados','devolvidas'));
	}

	public function coordenadorDash()
	{
		$repo = new SolicitacaoRepository();

		$abertas = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento'));
		$aprovadas = $repo->getSolicitacaoCoordenador(config('constantes.status_aprovado'));
		$reprovados = $repo->getSolicitacaoCoordenador(config('constantes.status_reprovado'));
		$devolvidas = $repo->getSolicitacaoCoordenador(config('constantes.status_devolvido'));
		$recorrentes = $repo->getSolicitacaoCoordenador(config('constantes.status_recorrente'));
		
		return view('dashboard.coordenador',compact('abertas','aprovadas','reprovados','devolvidas','recorrentes'));
	}
	public function financeiroDash()
	{
		$repo = new SolicitacaoRepository();

		$abertas = $repo->getSolicitacaoFinanceiro(config('constantes.status_aprovado'));
		$finalizadas = $repo->getSolicitacaoFinanceiro(config('constantes.status_finalizado'));
		$devolvidas = $repo->getSolicitacaoFinanceiro(config('constantes.status_devolvido_financeiro'));
		$recorrentes = $repo->getSolicitacaoFinanceiro(config('constantes.status_aprovado_recorrente'));

		return view('dashboard.financeiro',compact('abertas','finalizadas','devolvidas','recorrentes'));

	}

}

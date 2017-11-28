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
		$abertasEtapa2 = $repo->getSolicitacaoAdvogado(config('constantes.status_aberto_etapa2'));

		if ($abertasEtapa2 !=null) {
			$abertas=$this->pushSolicitacao($abertas,$abertasEtapa2);
		}

		$andamentos = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento'));
		$andamentos2 = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento_etapa2'));
		if ($andamentos !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$andamentos2);
		}
		$recorrente = $repo->getSolicitacaoAdvogado(config('constantes.status_recorrente'));
		$andamento_recorrente = $repo->getSolicitacaoAdvogado(config('constantes.status_andamento_recorrente'));


		
		
		if ($recorrente !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$recorrente);
		}
		if ($andamento_recorrente !=null) {
			$andamentos=$this->pushSolicitacao($andamentos,$andamento_recorrente);
		}

		$aprovadas = $repo->getSolicitacaoAdvogado(config('constantes.status_aprovado'));
		$finalizados = $repo->getSolicitacaoAdvogado(config('constantes.status_finalizado'));	

		if ($finalizados !=null) {
			$aprovadas=$this->pushSolicitacao($aprovadas,$finalizados);
		}	
		$reprovados = $repo->getSolicitacaoAdvogado(config('constantes.status_reprovado'));
		$devolvidas = $repo->getSolicitacaoAdvogado(config('constantes.status_devolvido'));

		return view('dashboard.advogado',compact('abertas','andamentos','aprovadas','reprovados','devolvidas'));
	}

	public function pushSolicitacao($solicitacoes,$pushSolici)
	{
		foreach ($pushSolici->solicitacao as $key => $value) {

			$solicitacoes->solicitacao->push($value);
		}
		return $solicitacoes;
	}

	public function coordenadorDash()
	{
		$repo = new SolicitacaoRepository();

		$abertas = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento'));

		$abertas2 = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento_etapa2'));
		
		if ($abertas2 !=null) {
			$abertas =$this->pushSolicitacao($abertas,$abertas2);			
		}
		$aprovadas = $repo->getSolicitacaoCoordenador(config('constantes.status_aprovado'));
		$aprovadas_recorrente = $repo->getSolicitacaoCoordenador(config('constantes.status_aprovado_recorrente'));
		
		if ($aprovadas_recorrente !=null) {
			$aprovadas =$this->pushSolicitacao($aprovadas,$aprovadas_recorrente);			
		}
		$reprovados = $repo->getSolicitacaoCoordenador(config('constantes.status_reprovado'));
		$devolvidas = $repo->getSolicitacaoCoordenador(config('constantes.status_devolvido'));
		$recorrentes = $repo->getSolicitacaoCoordenador(config('constantes.status_recorrente'));
		$andamento_recorrente = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento_recorrente'));
		
		if ($andamento_recorrente !=null) {
			$recorrentes = $this->pushSolicitacao($recorrentes,$andamento_recorrente);			
		}
		return view('dashboard.coordenador',compact('abertas','aprovadas','reprovados','devolvidas','recorrentes'));
	}
	public function financeiroDash()
	{
		$repo = new SolicitacaoRepository();

		$abertas = $repo->getSolicitacaoFinanceiro(config('constantes.status_aprovado'));
		$andamento = $repo->getSolicitacaoFinanceiro(config('constantes.status_andamento_financeiro'));
		if ($andamento !=null) {
			$abertas= $this->pushSolicitacao($abertas,$andamento);
		}
		$finalizadas = $repo->getSolicitacaoFinanceiro(config('constantes.status_finalizado'));
		$devolvidas = $repo->getSolicitacaoFinanceiro(config('constantes.status_devolvido_financeiro'));
		$recorrentes_devolvidas = $repo->getSolicitacaoFinanceiro(config('constantes.status_recorrente'));
		if ($devolvidas !=null) {
			$devolvidas= $this->pushSolicitacao($devolvidas,$recorrentes_devolvidas);
		}
		$recorrentes = $repo->getSolicitacaoFinanceiro(config('constantes.status_aprovado_recorrente'));

		return view('dashboard.financeiro',compact('abertas','finalizadas','devolvidas','recorrentes'));

	}

}

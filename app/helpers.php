<?php 	
use Illuminate\Support\Facades\Auth;
use App\Repositories\SolicitacaoRepository;

function getChamados()
{
	$repo = new SolicitacaoRepository();

	if (Auth::user()->hasRole(config('constantes.user_coordenador'))) {
		$abertas = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento'));

		$andamentos_etapa2 = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento_etapa2'));

		if ($andamentos_etapa2 !=null) {
			$abertas= pushSolicitacao($abertas,$andamentos_etapa2);
		}
		return count($abertas->solicitacao);
	}
	if (Auth::user()->hasRole(config('constantes.user_financeiro'))) {
		$abertas = $repo->getSolicitacaoFinanceiro(config('constantes.status_aprovado'));
		$aprovado_etapa2 = $repo->getSolicitacaoFinanceiro(config('constantes.status_aprovado_etapa2'));
		if ($aprovado_etapa2 !=null) {
			$abertas = pushSolicitacao($abertas,$aprovado_etapa2);			
		}
		$andamento = $repo->getSolicitacaoFinanceiro(config('constantes.status_andamento_financeiro'));
		if ($andamento !=null) {
			$abertas= pushSolicitacao($abertas,$andamento);
		}
		return count($abertas->solicitacao);
	}
	if (Auth::user()->hasRole(config('constantes.user_administrativo'))) {
		$abertas = $repo->getSolicitacaoAdministrativo(config('constantes.status_aprovado'));

		$andamento = $repo->getSolicitacaoAdministrativo(config('constantes.status_andamento_administrativo'));
		if ($andamento !=null) {
			$abertas= pushSolicitacao($abertas,$andamento);
		}
		return count($abertas->solicitacao);
	}
	
}

function pushSolicitacao($solicitacoes,$pushSolici)
{
	foreach ($pushSolici->solicitacao as $key => $value) {

		$solicitacoes->solicitacao->push($value);
	}
	return $solicitacoes;
}

?>
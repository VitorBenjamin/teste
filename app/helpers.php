<?php 	
use Illuminate\Support\Facades\Auth;
use App\Repositories\SolicitacaoRepository;

function getChamados()
{
	$repo = new SolicitacaoRepository();

	$abertas = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento'));

	$andamentos_etapa2 = $repo->getSolicitacaoCoordenador(config('constantes.status_andamento_etapa2'));

	if ($andamentos_etapa2 !=null) {
		$abertas= pushSolicitacao($abertas,$andamentos_etapa2);
	}
	return count($abertas->solicitacao);
}
function pushSolicitacao($solicitacoes,$pushSolici)
{
	foreach ($pushSolici->solicitacao as $key => $value) {

		$solicitacoes->solicitacao->push($value);
	}
	return $solicitacoes;
}
?>
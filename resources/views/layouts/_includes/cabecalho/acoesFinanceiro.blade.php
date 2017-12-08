@if(($solicitacao->tipo == "COMPRA") && $solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_financeiro'))
<a href="{{ route('solicitacao.aprovar',$solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
	<i class="material-icons">low_priority</i>
	<span>ENVIAR PARA APROVAÇÂO</span>
</a>
<a  data-toggle="modal" data-target="#modalDevolver" class="btn bg-lime waves-effect" role="button">
	<i class="material-icons">report_problem</i>
	<span>DEVOLVER</span>
</a>
@elseif($solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado_etapa2'))

<a href="{{ route('solicitacao.finalizar',$solicitacao->id) }}" class="btn bg-light-green waves-effect" role="button">
	<i class="material-icons">done_all</i>
	<span>FINALIZAR</span>
</a>
<a  data-toggle="modal" data-target="#modalDevolver" class="btn bg-lime waves-effect" role="button">
	<i class="material-icons">report_problem</i>
	<span>DEVOLVER</span>
</a>										
@endif

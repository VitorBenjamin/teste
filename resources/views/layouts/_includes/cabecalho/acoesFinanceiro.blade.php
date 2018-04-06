@if(($solicitacao->tipo == "COMPRA" || $solicitacao->tipo == "VIAGEM") && $solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_administrativo') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_recorrente_financeiro'))
<a href="{{ route('solicitacao.andamento',$solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
	<i class="material-icons">low_priority</i>
	<span>ENVIAR PARA APROVAÇÂO</span>
</a>
<a  data-toggle="modal" data-target="#modalDevolver" class="btn bg-lime waves-effect" role="button">
	<i class="material-icons">report_problem</i>
	<span>DEVOLVER</span>
</a>
@elseif($solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado_etapa2'))

@if($solicitacao->tipo == "VIAGEM")
<a href="{{ route('solicitacao.finalizar',$solicitacao->id) }}" class="btn bg-light-green waves-effect" role="button">
	<i class="material-icons">done_all</i>
	<span>FINALIZAR</span>
</a>
@else
<a href="{{ route('solicitacao.finalizar',$solicitacao->id) }}" class="btn bg-light-green waves-effect {{count($solicitacao->comprovante) == 0 ? 'not-active' : ''}}" role="button" {{count($solicitacao->comprovante) == 0 ? 'disabled' : ''}}>
	<i class="material-icons">done_all</i>
	<span>FINALIZAR</span>
</a>
@endif


@if($solicitacao->tipo == "COMPRA" && $solicitacao->status()->get()[0]->descricao != config('constantes.status_aprovado')) 
<a  data-toggle="modal" data-target="#modalDevolver" class="btn bg-lime waves-effect" role="button">
<i class="material-icons">report_problem</i>
	<span>DEVOLVER</span>
</a>
@endif										
@endif

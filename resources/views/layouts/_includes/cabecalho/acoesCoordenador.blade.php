@if(($solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_etapa2') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_recorrente') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_recorrente')))
@if($solicitacao->tipo =="COMPRA")
@if($solicitacao['aprovado'])
<a href="{{ route('solicitacao.aprovar',$solicitacao->id) }}" class="btn bg-green waves-effect" role="button">
	<i class="material-icons">done_all</i>
	<span>APROVAR</span>
</a>
@else
<a href="{{ route('solicitacao.aprovar',$solicitacao->id) }}" class="btn bg-green waves-effect not-active" role="button" disabled>
	<i class="material-icons">done_all</i>
	<span>APROVAR</span>
</a>
@endif
@else
<a href="{{ route('solicitacao.aprovar',$solicitacao->id) }}" class="btn bg-green waves-effect" role="button">
	<i class="material-icons">done_all</i>
	<span>APROVAR</span>
</a>
@endif
@if($solicitacao->users_id != auth()->user()->id)
<a  data-toggle="modal" data-target="#modalDevolver" href="{{ route('solicitacao.devolver',$solicitacao->id) }}" class="btn bg-lime waves-effect" role="button">
	<i class="material-icons">report_problem</i>
	<span>DEVOLVER</span>
</a>
@endif
@if($solicitacao->status()->get()[0]->descricao != config('constantes.status_andamento_etapa2'))
<a href="{{ route('solicitacao.reprovar',$solicitacao->id) }}" class="btn bg-red waves-effect" role="button">
	<i class="material-icons">cancel</i>
	<span>REPROVAR</span>
</a>
@endif
@endif
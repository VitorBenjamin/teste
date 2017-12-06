@if($solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_etapa2') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_recorrente') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_recorrente'))
<a href="{{ route('solicitacao.aprovar',$solicitacao->id) }}" class="btn bg-light-green waves-effect" role="button">
	<i class="material-icons">done_all</i>
	<span>APROVAR</span>
</a>										
<a  data-toggle="modal" data-target="#modalDevolver" href="{{ route('solicitacao.devolver',$solicitacao->id) }}" class="btn bg-lime waves-effect" role="button">
	<i class="material-icons">report_problem</i>
	<span>DEVOLVER</span>
</a>
@if($solicitacao->status()->get()[0]->descricao != config('constantes.status_andamento_etapa2'))
<a href="{{ route('solicitacao.reprovar',$solicitacao->id) }}" class="btn bg-green waves-effect" role="button">
	<i class="material-icons">cancel</i>
	<span>REPROVAR</span>
</a>
@endif
@endif
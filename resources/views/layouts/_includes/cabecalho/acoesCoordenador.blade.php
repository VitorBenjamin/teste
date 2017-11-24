<a href="{{ route('solicitacao.aprovar',$solicitacao->id) }}" class="btn bg-light-green waves-effect" role="button">
	<i class="material-icons">done_all</i>
	<span>APROVAR</span>
</a>										
<a href="{{ route('solicitacao.devolver',$solicitacao->id) }}" class="btn bg-lime waves-effect" role="button">
	<i class="material-icons">report_problem</i>
	<span>DEVOLVER</span>
</a>
<a href="{{ route('solicitacao.reprovar',$solicitacao->id) }}" class="btn bg-green waves-effect" role="button">
	<i class="material-icons">cancel</i>
	<span>REPROVAR</span>
</a>

<!-- INCIO CABEÇALHO PADRAO -->
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			@role(['COORDENADOR'])
			<div class="header">
				<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
					<a href="{{ route('solicitacao.aprovar',$solicitacao->id) }}" class="btn bg-light-green waves-effect" role="button">
						<i class="material-icons">done_all</i>
						<!-- <span class="hidden-xs">ADD</span> -->
						<span>APROVAR</span>
					</a>
					<a href="{{ route('solicitacao.reprovar',$solicitacao->id) }}" class="btn bg-green waves-effect" role="button">
						<i class="material-icons">report_problem</i>
						<span>REPROVAR</span>
					</a>
					<a href="{{ route('solicitacao.devolver',$solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
						<i class="material-icons">report_problem</i>
						<span>DEVOLVER</span>
					</a>
				</div>
			</div>
			@endrole
			<div class="container">
				<div class="row">
					<div class="col-md-1">
						<h5>Despesa</h5>
						<p>{{ $solicitacao->origem_despesa }}</p>
					</div>
					<div class="col-md-2">
						<h5>Cliente</h5>
						<p>{{$solicitacao->clientes == null ? 'MoselloLima' : $solicitacao->clientes->nome }}</p>
					</div>
					<div class="col-md-2">
						<h5>Solicitante</h5>
						<p>{{$solicitacao->solicitante == null ? 'Desconhecido' : $solicitacao->solicitante->nome }}</p>
					</div>
					<div class="col-md-3">
						<h5>Número de Processo</h5>
						<p>{{$solicitacao->processo == null ? 'Sem Processo' : $solicitacao->processo->codigo }}</p>
					</div>
					<div class="col-md-2">
						<h5>Área de Atendimento</h5>
						<p>{{$solicitacao->area_atuacao->tipo}}</p>
					</div>
					<div class="col-md-2">
						<h5>Tipo de contrato</h5>
						<p>{{ $solicitacao->contrato }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- FIM CABEÇALHO PADRAO -->

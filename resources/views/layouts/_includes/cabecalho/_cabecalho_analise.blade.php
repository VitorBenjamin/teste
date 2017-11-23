<!-- INCIO CABEÇALHO PADRAO -->
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			@role(['COORDENADOR','FINANCEIRO'])
			<div class="header">
				<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
					<a href="{{ route('solicitacao.aprovar',$solicitacao->id) }}" class="btn bg-light-green waves-effect" role="button">
						<i class="material-icons">done_all</i>
						<!-- <span class="hidden-xs">ADD</span> -->
						<span>APROVAR</span>
					</a>
					@role(['COORDENADOR'])
					<a href="{{ route('solicitacao.reprovar',$solicitacao->id) }}" class="btn bg-green waves-effect" role="button">
						<i class="material-icons">report_problem</i>
						<span>REPROVAR</span>
					</a>
					@endrole
					<a href="{{ route('solicitacao.devolver',$solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
						<i class="material-icons">report_problem</i>
						<span>DEVOLVER</span>
					</a>
				</div>
			</div>
			@endrole
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-6 col-sm-1">
						<h5>Despesa</h5>
						<p>{{ $solicitacao->origem_despesa }}</p>
					</div>
					<div class="col-xs-6 col-sm-2">
						<h5>Cliente</h5>
						<p>{{$solicitacao->cliente == null ? 'Mosello Lima' : $solicitacao->cliente->nome }}</p>
					</div>
					<div class="col-xs-5 col-sm-3 col-md-2">
						<h5>Solicitante</h5>
						<p>{{$solicitacao->solicitante == null ? 'Desconhecido' : $solicitacao->solicitante->nome }}</p>
					</div>
					<div class="col-xs-7 col-sm-3">
						<h5>N° de Processo</h5>
						<p>{{$solicitacao->processo == null ? 'Sem Processo' : $solicitacao->processo->codigo }}</p>
					</div>
					<div class="col-xs-6 col-sm-2">
						<h5>Área de Atendi..</h5>
						<p>{{$solicitacao->area_atuacao->tipo}}</p>
					</div>
					<div class="col-xs-6 col-sm-2 col-md-1">
						<h5>Contrato</h5>
						<p>{{ $solicitacao->contrato }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- FIM CABEÇALHO PADRAO -->

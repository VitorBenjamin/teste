@extends('layouts.app')
@section('content')
<section class="content">
	<div class="block-header">
		<h2>Dados da Solicitação</h2>
	</div>
	
	<!-- COMEÇO CABEÇALHO PADRÃO -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="header">
				@if(Session::has('flash_message'))
				<div align="center" class="{{ Session::get('flash_message')['class'] }}" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Session::get('flash_message')['msg'] }}
				</div>								
				@endif
			</div>
		</div>
	</div>
	
	<!-- INCIO CABEÇALHO PADRAO -->
	@include('layouts._includes.cabecalho._cabecalho_analise')
	<!-- FIM CABEÇALHO PADRAO -->

	<!-- MODAL COMENTÁRIO -->
	@include('layouts._includes._modalComentario')
	<!-- FIM MODAL COMENTÁRIO -->
	
	<!-- SESSÂO COMENTÁRIO -->
	@if(count($solicitacao->comentarios) > 0)
	@include('layouts._includes._comentario')
	@endif
	<!-- FIM SESSÂO COMENTÁRIO  -->
	
	<!-- SESSÂO COMPROVANTE -->
	@if(count($solicitacao->comprovante) == 0)
	@include('layouts._includes.solicitacoes._addComprovante')
	@else
	@include('layouts._includes.solicitacoes._comprovante')
	@endif 
	<!-- FIM SESSÂO COMPROVANTE  -->


	<!-- LISTAGEM DOS TRANSLADOS  -->
	@if (count($solicitacao->translado) > 0)
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DOS TRANSLADOS
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped nowrap table-hover dataTable">
						<thead>
							<tr>
								<th>Data</th>
								<th>Origem</th>
								<th>Destino</th>
								<th>Ida/Volta</th>
								<th>Distância</th>
								<th>Valor Km</th>
								<th>Total Km</th>
								<th>Motivo</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($solicitacao->translado as $translado)

							<tr>
								<td>{{date('d/m/Y',strtotime($translado->data_translado))}}</td>
								<td>{{$translado->origem}}</td>
								<td>{{$translado->destino}}</td>
								<td>{{$translado->ida_volta == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$translado->distancia}} Km</td>
								<td>R$ {{$solicitacao->cliente->valor_km}}</td>
								<td>{{$solicitacao->cliente->valor_km * $translado->distancia}}</td>
								<td>{{$translado->observacao}}</td>
							</tr>
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@endif
	<!-- FIM LISTAGEM DOS TRANSLADOS -->
	
	<!-- LISTAGEM DAS DESPESAS  -->
	@if (count($solicitacao->despesa) > 0)
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DAS DESPESAS
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped table-hover dataTable">
						<thead>
							<tr>
								<th>Data</th>
								<th>Descricao</th>
								<th>Comprovante</th>
								<th>Valor</th>
								<th>Ação</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Data</th>
								<th>Descricao</th>
								<th>Comprovante</th>
								<th>Valor</th>
								<th>Ação</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($solicitacao->despesa as $key => $despesa)
							<tr>
								<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
								<td>{{$despesa->descricao}}</td>
								<td>{{$despesa->tipo_comprovante}}</td>
								<td>{{$despesa->valor}}</td>
								<td class="acoesTD">
									<div class="zoom-gallery">
										@if($despesa->anexo_pdf)
										<span>
											<a id="broken-image" class="mfp-image" target="_blank" href="{{URL::to('storage/despesas/'.$despesa->anexo_pdf)}}"><i class="material-icons">picture_as_pdf</i></a>
										</span>
										@else
										<a href="{{$despesa->anexo_comprovante}}" data-source="{{$despesa->anexo_comprovante}}" title="COMPROVANTE - {{$despesa->tipo_comprovante}} - {{date('d/m/Y',strtotime($despesa->data_despesa))}}" style="width:32px;height:32px;">
											<img class="img_popup" src="{{$despesa->anexo_comprovante}}" width="32" height="32">
										</a>
										@endif
									</div>
								</td>
							</tr>
							@endforeach														
						</tbody>
					</table>
					<div class="row clearfix visible-xs">
						<div class="body">
							<div class="zoom-gallery2">
								@foreach ($solicitacao->despesa as $key => $despesa)
								@if($despesa->anexo_pdf)
								<span>
									<a id="broken-image" class="mfp-image" target="_blank" href="{{URL::to('storage/despesas/'.$despesa->anexo_pdf)}}"><i class="material-icons">picture_as_pdf</i></a>
								</span>
								@else
								<a href="{{$despesa->anexo_comprovante}}" data-source="{{$despesa->anexo_comprovante}}" title="COMPROVANTE - {{$despesa->tipo_comprovante}} - {{date('d/m/Y',strtotime($despesa->data_despesa))}}" style="width:32px;height:32px;">
									<img class="img_popup" src="{{$despesa->anexo_comprovante}}" width="32" height="32">
								</a>
								@endif
								@endforeach	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
	<!-- FIM LISTAGEM DOS DESPESAS -->

</section>
@endsection
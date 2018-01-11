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
	@include('layouts._includes._comentario')
	<!-- FIM SESSÂO COMENTÁRIO  -->
	
	<!-- LISTAGEM DOS TRANSLADOS  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DOS TRANSLADOS
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped nowrap table-hover dataTable table-simples">
						<thead>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Origem</th>
								<th>Destino</th>
								<th>Ida/Volta</th>
								<th>Distância</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($solicitacao->translado as $translado)

							<tr>
								<td></td>
								<td>{{date('d/m/Y',strtotime($translado->data_translado))}}</td>
								<td>{{$translado->origem}}</td>
								<td>{{$translado->destino}}</td>
								<td>{{$translado->ida_volta == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$translado->distancia}}</td>
							</tr>
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- FIM LISTAGEM DOS TRANSLADOS -->
	
	<!-- LISTAGEM DAS DESPESAS  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DAS DESPESAS
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
						<thead>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Descricao</th>
								<th>Comprovante</th>
								<th>Valor</th>
								<th>Ação</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
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
								<td></td>
								<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
								<td>{{$despesa->descricao}}</td>
								<td>{{$despesa->tipo_comprovante}}</td>
								<td>{{$despesa->valor}}</td>
								<td class="acoesTD"> 
									<!-- <div class="icon-button-demo" >
										<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" onclick="openModal();currentSlide({{$key+1}})">
											<i class="material-icons">photo_library</i>
										</a>
									</div> -->
									<div class="zoom-gallery">

										<a href="{{$despesa->anexo_comprovante}}" data-source="{{$despesa->anexo_comprovante}}" title="{{$despesa->tipo_comprovante}} - {{date('d/m/Y',strtotime($despesa->data_despesa))}}" style="width:32px;height:32px;">
											<img src="{{$despesa->anexo_comprovante}}" width="32" height="32">
										</a>
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
									<a href="{{$despesa->anexo_comprovante}}" data-source="{{$despesa->anexo_comprovante}}" title="{{$despesa->tipo_comprovante}} - {{date('d/m/Y',strtotime($despesa->data_despesa))}}" style="width:32px;height:32px;">
										<img style="margin-bottom: 15px" src="{{$despesa->anexo_comprovante}}" width="32" height="32">
									</a>
									<a href="{{$despesa->anexo_comprovante}}" data-source="{{$despesa->anexo_comprovante}}" title="{{$despesa->tipo_comprovante}} - {{date('d/m/Y',strtotime($despesa->data_despesa))}}" style="width:32px;height:32px;">
										<img style="margin-bottom: 15px" src="{{$despesa->anexo_comprovante}}" width="32" height="32">
									</a>
								@endforeach	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FIM LISTAGEM DOS DESPESAS -->
</section>
@endsection
<!-- @push('scripts2')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.3/js/ajax-bootstrap-select.min.js') !!}
@endpush
@push('scripts')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap.min.js') !!}
{!! Html::script('https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js')!!}
@endpush -->
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
					<table class="table table-bordered table-striped nowrap table-hover dataTable js-exportable ">
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
								<td>{{date('d/m/y',strtotime($translado->data_translado))}}</td>
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
								<td>{{date('d/m/y',strtotime($despesa->data_despesa))}}</td>
								<td>{{$despesa->descricao}}</td>
								<td>{{$despesa->tipo_comprovante}}</td>
								<td>{{$despesa->valor}}</td>
								<td class="acoesTD"> 
									<div class="icon-button-demo" >
										<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" onclick="openModal();currentSlide({{$key+1}})">
											<i class="material-icons">photo_library</i>
										</a>
									</div>
								</td>
							</tr>
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- FIM LISTAGEM DOS DESPESAS -->
	<!-- MODAL GALERIA -->
	<div id="myModal" class="modal-2">
		<span class="close-2 cursor" onclick="closeModal()">&times;</span>
		<div class="modal-content-2">
			@foreach ($solicitacao->despesa as $key => $despesa)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label bg-teal">{{$despesa->tipo_comprovante}}</span><span class="label label-danger"> {{date('d/m/y',strtotime($despesa->data_despesa))}}</span></h3></div>
				<img src="{{$despesa->anexo_comprovante}}" style="width:100%; max-height: 70%">
			</div>
			@endforeach														

			<a class="prev-2" onclick="plusSlides(-1)">&#10094;</a>
			<a class="next-2" onclick="plusSlides(1)">&#10095;</a>

			<!-- <div class="caption-container">
				<p id="caption"></p>
			</div> -->
			<!-- 
			@foreach ($solicitacao->despesa as $key => $despesa)
			<div class="column">
				<img class="demo cursor" src="{{$despesa->anexo_comprovante}}" style="width:100%" onclick="currentSlide({{$key}})" alt="{{$despesa->descricao}}">
			</div>
			@endforeach -->

		</div>
	</div>
</section>
@endsection
<!-- @push('scripts')
<script src="{{ URL::asset('/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
<script src="{{ URL::asset('/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
<script src="{{ URL::asset('/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
<script src="{{ URL::asset('/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
@endpush -->
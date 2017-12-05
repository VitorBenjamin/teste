@extends('layouts.app')
@section('content')
<section class="content">
	<div class="block-header">
		<h2>Dados da Solicitação</h2>			
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
	
	<!-- LISTAGEM DA GUIA  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DAS GUIAS
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped nowrap table-hover dataTable js-basic-example">
						<thead>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Prioridade</th>
								<th>Reclamante</th>
								<th>Perfil Pagamento</th>
								<th>Banco</th>
								<th>Area</th>
								<th>Tipo</th>
								<th>Valor</th>
								<th>PDF</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Prioridade</th>
								<th>Reclamante</th>
								<th>Perfil Pagamento</th>
								<th>Banco</th>
								<th>Area</th>
								<th>Tipo</th>
								<th>Valor</th>
								<th>PDF</th>
							</tr>
						</tfoot>
						<tbody> 
							@foreach ($solicitacao->guia as $guia)
							<tr>
								<td></td>
								<td>{{date('d/m/y',strtotime($guia->data_limite))}}</td>
								<td>{{$guia->prioridade == 1 ? 'SIM' : 'NÃO' }}</td>
								<td>{{$guia->reclamante}}</td>									
								<td>{{$guia->perfil_pagamento}}</td>
								<td>{{$guia->banco}}</td>
								<td>{{$guia->tipoGuia()->first()->tipo}}</td>
								<td>{{$guia->tipoGuia()->first()->descricao}}</td>
								<td>{{  'R$ '.number_format($guia->valor, 2, ',', '.') }} </td>
								<td><a target="_blank" href="{{URL::to('storage/guias/'.$guia->anexo_pdf)}}" class="btn btn-primary waves-effect">
									<i class="material-icons">file_download</i>EXIBIR PDF</a>
								</td>
							</tr>
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div> 												
	</div>
	<!-- FIM LISTAGEM DA ANTECIPAÇÃO -->
</section>
@endsection
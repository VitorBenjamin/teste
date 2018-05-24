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
					<table class="table table-bordered table-striped table-hover dataTable table-simples-guia">
						<thead>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Prioridade</th>
								<th>Reclamante</th>
								<th>Perfil</th>
								<th>Banco</th>
								<th>Tipo</th>
								<th style="min-width:120px">Valor</th>
								<th>Observação</th>
								<th>Guia</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Prioridade</th>
								<th>Reclamante</th>
								<th>Perfil</th>
								<th>Banco</th>
								<th>Tipo</th>
								<th style="min-width:120px">Valor</th>
								<th>Observação</th>
								<th>Guia</th>
							</tr>
						</tfoot>
						<tbody> 
							@foreach ($solicitacao->guia as $guia)
							<tr>
								<td></td>
								<td>{{date('d/m/Y',strtotime($guia->data_limite))}}</td>
								<td>{{$guia->prioridade == 1 ? 'SIM' : 'NÃO' }}</td>
								<td>{{$guia->reclamante}}</td>									
								<td>{{$guia->perfil_pagamento}}</td>
								<td>{{$guia->banco}}</td>
								<td>{{$guia->tipoGuia()->first()->descricao}}</td>
								<td>R$ {{ $guia->valor }}</td>
								<td>{{$guia->observacao }} </td>
								<td>
									<div class="zoom-gallery">
										<a href="{{$guia->anexo_guia}}" data-source="{{$guia->anexo_guia}}" title="GUIA - {{date('d/m/Y',strtotime($guia->data_limite))}}" style="width:32px;height:32px;">
											<img class="img_popup" src="{{$guia->anexo_guia}}" width="32" height="32">
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
	<!-- FIM LISTAGEM DA ANTECIPAÇÃO -->
	
</section>
@endsection
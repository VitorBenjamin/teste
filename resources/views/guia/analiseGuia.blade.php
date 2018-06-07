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
								<th style="min-width:120px; text-align:right">Valor</th>
								<th>Observação</th>
								<th style="min-width:120px;">Guia</th>
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
								<th style="min-width:100px; text-align:right">Valor</th>
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
								<td style="min-width:120px; text-align:right">R$ {{ $guia->valor }}</td>
								<td>{{$guia->observacao }} </td>
								<td class="acoesTD">
									<div class="zoom-gallery" style="display: inline;">
										<a href="{{$guia->anexo_guia}}" data-source="{{$guia->anexo_guia}}" title="GUIA - {{date('d/m/Y',strtotime($guia->data_limite))}}" style="width:32px;height:32px;">
											<img class="img_popup" src="{{$guia->anexo_guia}}" width="32" height="32">
										</a>
										@if($guia->anexo_comprovante)
										<a href="{{$guia->anexo_comprovante}}" data-source="{{$guia->anexo_comprovante}}" title="GUIA - {{$guia->data_comprovante ? date('d/m/Y',strtotime($guia->data_comprovante)) : ''}}" style="width:32px; height:32px;">
											<img class="img_popup" src="{{$guia->anexo_comprovante}}" width="32" height="32">
										</a>
										@endif
									</div>
									@role(['FINANCEIRO','ADMINISTRATIVO'])
									<a data-toggle="modal" data-target="#modalGuia{{$guia->id}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float" role="button">
										<i class="material-icons">attach_file</i>
									</a>
									@endrole
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
@role(['FINANCEIRO','ADMINISTRATIVO'])
@foreach ($solicitacao->guia as $guia)
<!-- MODAL CADASTRO DA GUIA -->
<div class="modal fade" id="modalGuia{{$guia->id}}" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="largeModalLabel">Adicione um comprovante no valor de R$ {{$guia->valor}}</h4>
			</div>
			<!-- INCIO SESSÃO VIAGEM -->
			<div class="modal-body">
				<form action="{{ route('guia.addComprovante',$guia->id)}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}			
					<div class="body">
						<div class="row clearfix">
							<div class="col-md-4">
								<div class="form-group">
									<div class="form-line">
										<label for="data_comprovante">Data</label>
										<input type="text" value="" name="data_comprovante" class="datepicker form-control" placeholder="Escolha uma Data" required />
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<div class="form-line">
										<label for="anexo_comprovante">Anexar Guia (JPG)</label>
										<input style="margin-top: 10px " type="file" name="anexo_comprovante" id="anexo_comprovante" accept="image/jpeg,image/jpg" required/>
									</div>
								</div>								
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-info">
								<i class="material-icons">save</i>
								<span>ADD COMPROVANTE</span>
							</button>
						</div>
						<!-- <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button> -->
						<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- FIM MODAL CADASTRO DA PRODUTO -->
@endforeach
@endrole
@endsection
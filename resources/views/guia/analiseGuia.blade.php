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
	<div class="modal fade" id="modalDevolver" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">DESEJA DEVOLVER ESSA SOLICITAÇÂO?</h4>
				</div>
				<!-- INCIO SESSÃO DESPESA -->
				<div class="modal-body">
					<form action="{{ route('solicitacao.devolver',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="body">
							<div class="row clearfix">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="card">
										<div class="header">
											<h2>
												Deixe uma Observação 
											</h2>
										</div>
										<div class="body">
											<div class="row clearfix">
												<div class="col-md-12">
													<div class="form-group">
														<div class="form-line">
															<label for="comentario">Observação</label>
															<textarea name="comentario" class="form-control" placeholder="..." required></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<div class="form-group">
												<button class="btn btn-info">
													<i class="material-icons">replay</i>
													<span>DEVOLVER</span>
												</button>
											</div>
											<!-- <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button> -->
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- FIM SESSÃO DESPESA -->
					</form>
				</div>
			</div>
		</div>
	</div>	
	<!-- FIM MODAL COMENTÁRIO -->
	
	<!-- LISTAGEM DA VIAGEM  -->
	@include('layouts._includes._comentario')
	<!-- FIM LISTAGEM DA VIAGEM  -->
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
@extends('layouts.app')
@section('content')
<script type="text/javascript">
	var urlClientes = "{{route('cliente.getCliente')}}";

	var urlSoli = "{{route('solicitante.getSolicitante')}}";
</script>
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
	
	<!-- LISTAGEM DA ANTECIPAÇÃO  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTA DE ANTECIPAÇÂO
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped nowrap table-hover dataTable js-basic-example ">
						<thead>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Descrição</th>
								<th>Valor</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($solicitacao->antecipacao as $key => $antecipacao)
							<tr>
								<td></td>
								<td>{{date('d-m-y',strtotime($antecipacao->data_recebimento))}}</td>
								<td>{{$antecipacao->descricao}}</td>
								<td>{{$antecipacao->valor}}</td>
								<td class="acoesTD">
									@role('FINANCEIRO')
									<button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#addComprovante{{$antecipacao->id}}">ANEXAR</button>
									@endrole
									@if($antecipacao->anexo_comprovante == null)
									<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" disabled>
										<i class="material-icons">photo_library</i>
									</a>
									@else
									
									<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" onclick="openModal();currentSlide({{$key}})"  data-placement="top" title="VISUALIZAR COMPROVANTE" data-toggle="tooltip">
										<i class="material-icons">photo_library</i>
									</a>
									@endif
								</td>									
							</tr>
							<div class="modal fade" id="addComprovante{{$antecipacao->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="defaultModalLabel">COMPROVANTE DA ANTECIPAÇÃO</h4>
										</div>
										<div class="modal-body">
											<form action="{{ route('antecipacao.addComprovante',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
												{{ csrf_field() }}
												{{ method_field('PUT') }}
												<input type="hidden" name="antecipacao_id" value="{{$antecipacao->id}}">
												<div class="col-md-12">
													<div class="col-md-8">
														<div class="form-group">
															<div class="form-line">
																<label style="margin-bottom: 20px" for="anexo_comprovante">Comprovante da Antecipação (jpeg,bmp,png)</label>
																<input type="file" name="anexo_comprovante" id="anexo_comprovante" required/>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<div class="form-group">
														<button class="btn btn-info">
															<i class="material-icons">save</i>
															<span>ANEXAR COMPROVANTE</span>
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
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div> 												
	</div>
	<!-- FIM LISTAGEM DA ANTECIPAÇÃO -->

	<!-- MODAL GALERIA -->
	<div id="myModal" class="modal-2">
		<span class="close-2 cursor" onclick="closeModal()">&times;</span>
		<div class="modal-content-2">
			@foreach ($solicitacao->antecipacao as $key => $antecipacao)
			<div class="mySlides">
				<!-- <div class="numbertext"><span class="badge bg-cyan">{{$key+1}} / {{count($solicitacao->despesa)}}</span></div> -->
				<img src="{{$antecipacao->anexo_comprovante}}" style="width:100%; max-height: 70%">
			</div>
			@endforeach														

			<!-- <a class="prev-2" onclick="plusSlides(-1)">&#10094;</a> -->
			<!-- <a class="next-2" onclick="plusSlides(1)">&#10095;</a> -->

			</div>
		</div>
		<!-- FIM MODAL GALERIA -->
	</section>
	@endsection
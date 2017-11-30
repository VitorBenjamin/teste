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
	<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sodales orci ante, sed ornare eros vestibulum ut. Ut accumsan
					vitae eros sit amet tristique. Nullam scelerisque nunc enim, non dignissim nibh faucibus ullamcorper.
					Fusce pulvinar libero vel ligula iaculis ullamcorper. Integer dapibus, mi ac tempor varius, purus
					nibh mattis erat, vitae porta nunc nisi non tellus. Vivamus mollis ante non massa egestas fringilla.
					Vestibulum egestas consectetur nunc at ultricies. Morbi quis consectetur nunc.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
				</div>
			</div>
		</div>
	</div>
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
								<td>{{date('d/m/y',strtotime($antecipacao->data_recebimento))}}</td>
								<td>{{$antecipacao->descricao}}</td>
								<td>{{$antecipacao->valor}}</td>
								<td class="acoesTD">
									@role('FINANCEIRO')
									<button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">ANEXO</button>
									@endrole
									<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" {{$antecipacao->anexo_comprovante == null ? 'disabled' : ''}} 
										onclick="{{$antecipacao->anexo_comprovante == null ? '' : 'openModal();currentSlide($key+1)'}}" >
										<i class="material-icons">photo_library</i>
									</a>
								</td>									
							</tr>
							<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="defaultModalLabel">COMPROVANTE DE ENTREGA DA ANTECIPAÇÂO</h4>
										</div>
										<div class="modal-body">
											<form action="{{ route('antecipacao.addComprovante',$antecipacao->id)}}" method="POST" enctype="multipart/form-data">
												{{ csrf_field() }}
												{{ method_field('PUT') }}
												<div class="col-md-12">
													<div class="form-group">
														<div class="form-line">
															<label for="anexo_comprovante">Envie um Arquivo</label>
															<input type="file" name="anexo_comprovante" id="anexo_comprovante" required/>
															<button type="reset" id="pseudoCancel">
																Cancel
															</button>
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

			<!-- <a class="prev-2" onclick="plusSlides(-1)">&#10094;</a>
				<a class="next-2" onclick="plusSlides(1)">&#10095;</a> -->

			</div>
		</div>
		<!-- FIM MODAL GALERIA -->

		<!-- ANEXAR COMPROVANTE DE ANTECIPAÇÂO -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							Preencha os campos abaixo com atenção
						</h2>
					</div>
					<div class="body">
						<form action="{{ route('antecipacao.addComprovante',$solicitacao->antecipacao->get(0)->id)}}" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
							{{ method_field('PUT') }}
							<div class="row clearfix">
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_despesa">Data</label>
											<input type="text" name="data_despesa" class="datepicker form-control" placeholder="Escolha uma Data" required />
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<label for="tipo_comprovante">Comprovante</label>
									<select id="tipo_comprovante" name="tipo_comprovante" class="form-control show-tick" required>
										<option value="HOSPEDAGEM">HOSPEDAGEM</option>
										<option value="ALIMENTAÇÂO">ALIMENTAÇÃO</option>
										<option value="TRANSPORTE">TRANSPORTE</option>
									</select>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="form-line">
											<label for="descricao">Descrição</label>
											<input type="text" name="descricao" class="form-control" placeholder="Deixe uma breve descrição" required/>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="valor_aprovado">Valor</label>
											<input type="text" id="valor_aprovado" name="valor_aprovado" class="form-control" placeholder="R$." required/>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="form-line">
											<label for="anexo_comprovante">Envie um Arquivo</label>
											<input type="file" name="anexo_comprovante" id="anexo_comprovante" required/>
											<button type="reset" id="pseudoCancel">
												Cancel
											</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-info">
								<i class="material-icons">save</i>
								<span>ADD DESPESA</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- FIM ANEXO COMPROVANTE DE ANTECIPAÇÂO -->
	</section>
	@endsection
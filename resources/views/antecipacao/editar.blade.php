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
	<!-- COMEÇO CABEÇALHO PADRÃO -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="header">
				@if(Session::has('flash_message'))
				<div align="center" class="{{ Session::get('flash_message')['class'] }}" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('flash_message')['msg'] }}
				</div>								
				@endif
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<!-- <h2>Cabecalho da Viagem</h2> -->
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#modalAntecipacao" class="btn bg-light-green waves-effect" role="button" 
						{{!empty($solicitacao->antecipacao[0]) ? 'disabled' : ''}}>
							<i class="material-icons">exposure_plus_1</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>ANTECIPAÇÂO</span>
						</a>
						<!-- <a data-toggle="modal" data-target="#modalDespesa" class="btn bg-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<span>DESPESA</span>
						</a> -->
						<!-- <a href="{{ route('solicitacao.andamento',$solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
							<i class="material-icons">send</i>
							<span>ENVIAR</span>
						</a> -->
					</div>
				</div>
				<form action="{{ route('solicitacao.atualizarCabecalho',$solicitacao->id)}}" method="POST">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					@include('layouts._includes.cabecalho._cabecalho-editar')
				</form>
			</div>
		</div>
	</div>
	<!-- FIM CABEÇALHO PADRAO -->
	
	<!-- LISTAGEM DA VIAGEM  -->
	@include('layouts._includes._comentario')
	<!-- FIM LISTAGEM DA VIAGEM  -->

	@if(empty($solicitacao->antecipacao[0]))
	<!-- MODAL CADASTRO DA ANTECIPAÇÂO -->
	<div class="modal fade" id="modalAntecipacao" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione uma Antecipação</h4>
				</div>
				<!-- INCIO SESSÃO VIAGEM -->
				<div class="modal-body">
					<form action="{{ route('antecipacao.addAntecipacao',$solicitacao->id)}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}			
						<div class="body">
							<div class="row clearfix">
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_recebimento">Data</label>
											<input type="text" value="" name="data_recebimento" class="datepicker2 form-control " placeholder="Escolha uma Data" required />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="form-line">
											<label for="descricao">Descrição</label>
											<input type="text" value="" name="descricao" class="form-control" placeholder="Descrição..." required />										
										</div>
									</div>
								</div>

								<div class="col-md-2">
									<b>Valor</b>
									<div class="input-group">
										<span class="input-group-addon">
											R$
										</span>
										<div class="form-line">
											<input type="numeric" name="valor" class="form-control valor" required />
										</div>
									</div>								
								</div>
								<!-- <div class="col-md-2" style="margin-top: 20px">
									<button class="btn btn-primary waves-effect">
										<i class="material-icons">save</i>
										<span>ADD ANTECIPAÇÃO</span> 
									</button>
								</div> -->
							</div>
						</div>
						<div class="modal-footer">
							<div class="form-group">
								<button class="btn btn-info">
									<i class="material-icons">save</i>
									<span>ADD ANTECIPAÇÃO</span>
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
	@endif
	<!-- SESSÃO ANTECIPAÇÂO -->
	@if(empty($solicitacao->antecipacao[0]))
	<!-- <div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Peça uma Antecipação
					</h2>
				</div>
				<div class="body">
					<form action="{{ route('antecipacao.addAntecipacao',$solicitacao->id)}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_recebimento">Data</label>
										<input type="text" value="" name="data_recebimento" class="datepicker2 form-control " placeholder="Escolha uma Data"/>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="form-line">
										<label for="descricao">Descrição</label>
										<input type="text" value="" name="descricao" class="form-control" placeholder="Descrição do produto"/>										
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<b>Valor</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input type="numeric" name="valor" class="form-control valor" />
									</div>
								</div>								
							</div>
							<div class="col-md-2" style="margin-top: 20px">
								<button class="btn btn-primary waves-effect">
									<i class="material-icons">save</i>
									<span>ADD ANTECIPAÇÃO</span> 
								</button>
							</div>
						</div>
					</form>	
				</div>			
			</div>			
		</div>
	</div> -->
	@endif
	<!-- FIM SESSÃO DA ANTECIPAÇÃO -->

	<!-- LISTAGEM DA ANTECIPAÇÃO  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTA DA ANTECIPAÇÃO
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
						<tfoot>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Descrição</th>
								<th>Valor</th>
								<th>Ações</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($solicitacao->antecipacao as $antecipacao)
							<tr>
								<td></td>
								<td>{{date('d/m/y',strtotime($antecipacao->data_recebimento))}}</td>
								<td>{{$antecipacao->descricao}}</td>
								<td>R$ {{$antecipacao->valor}}</td>									
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#modal{{$antecipacao->id}}" role="button"><i class="material-icons">settings</i></a>

										<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('antecipacao.deletarAntecipacao', $antecipacao->id)}}"><i class="material-icons">delete_sweep</i></a>
									</div>

								</td>
							</tr>


							<!-- MODAL EDIÇÂO DA ANTECIPAÇÂO -->
							<div class="modal fade" id="modal{{$antecipacao->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Editar um Antecipação</h4>
										</div>

										<!-- INCIO SESSÃO ANTECIPAÇÂO -->
										<form action="{{ route('antecipacao.atualizarAntecipacao',$antecipacao->id)}}" method="POST">
											{{ csrf_field() }}
											{{ method_field('PUT') }}
											<div class="modal-body">				

												<div class="row clearfix">
													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="data_recebimento">Data</label>
																<input type="text" value="{{$antecipacao->data_recebimento}}" name="data_recebimento" class="datepicker form-control" placeholder="Escolha uma Data"/>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<div class="form-line">
																<label for="descricao">Descrição</label>
																<input type="text" value="{{$antecipacao->descricao}}" name="descricao" class="form-control" placeholder="Descrição do produto"/>										
															</div>
														</div>
													</div>

													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="valor_solicitado">Valor Solicitado</label>
																<input type="text" value="{{$antecipacao->valor_solicitado}}" name="valor_solicitado" class="form-control" placeholder="Qtd."/>
															</div>
														</div>								
													</div>
													<div class="col-md-2" style="margin-top: 20px">
														<button class="btn btn-primary btn-lg waves-effect">
															<i class="material-icons">save</i>
															<span>ADD PRODUTO</span> 
														</button>
													</div>
												</div>
												<div class="modal-footer">													
													<!-- <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button> -->
													<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
												</div>

											</div>
										</form>	
									</div>
								</div>
							</div>
							<!-- FIM MODAL DE ANTECIPAÇÂO -->
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
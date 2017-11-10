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
					<h2>Cabecalho da Viagem</h2>
				</div>
				<form action="{{ route('compra.atualizarCabecalho',$solicitacao->id)}}" method="POST">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					@include('layouts._includes.cabecalho._cabecalho-editar')
				</form>
			</div>
		</div>
	</div>

	<!-- SESSÃO CADASTRO DA VIAGEM -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Adicione uma Passagem a sua solicitação
					</h2>
				</div>
				<div class="body">
					<form action="{{ route('viagem.addViagem',$solicitacao->id)}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="origem">Origem</label>
										<input type="text" value="" name="origem" class="form-control" placeholder="Cidade de origem" required />										
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_ida">Data Ida</label>
										<input type="text" value="" name="data_ida" class="datetimepicker form-control" placeholder="Data Obrigatória" required/>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="destino">Destino</label>
										<input type="text" value="" name="destino" class="form-control" placeholder="Cidade de DEstino" required/>										
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_volta">Data Volta</label>
										<input type="text" value="" name="data_volta" class="datetimepicker form-control" placeholder="Data Opcional"/>
									</div>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend style="margin: 0">Locação</legend>
									</fieldset>
									<input name="locacao" value="1" type="radio" id="simL" />
									<label style="margin: 15px 15px 0px 0px" for="simL">Sim</label>
									<input name="locacao" value="0" type="radio" id="naoL" checked />
									<label style="margin: 15px 15px 0px 0px" for="naoL">Não</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend style="margin: 0">Hospedagem</legend>
									</fieldset>
									<input name="hospedagem" value="1" type="radio" id="simH" />
									<label style="margin: 15px 15px 0px 0px" for="simH">Sim</label>
									<input name="hospedagem" value="0" type="radio" id="naoH" checked />
									<label style="margin: 15px 15px 0px 0px" for="naoH">Não</label>
								</div>
							</div>
							
						</div>
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend>Bagagem</legend>
									</fieldset>
									<input name="bagagem" value="1" type="radio" id="simB" />
									<label style="margin: 15px 15px 0px 0px" for="simB">Sim</label>
									<input name="bagagem" value="0" type="radio" id="naoB" checked/>
									<label style="margin: 15px 15px 0px 0px" for="naoB">Não</label>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="kg">Kg</label>
										<input type="text" value="" name="kg" class="form-control" placeholder="Kilos"/>
									</div>
								</div>								
							</div>
							<div class="col-md-2" style="margin-top: 20px">
								<button class="btn bg-deep-orange waves-effect">
									<i class="material-icons">save</i>
									<span>ADD VIAGEM</span> 
								</button>
							</div>
							
						</div>
						
					</div>
				</form>	
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
					LISTA DA VIAGEM
				</h2>
			</div>
			<div class="body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped nowrap table-hover dataTable js-basic-example ">
						<thead>
							<tr>
								<th></th>
								<th>Origem</th>
								<th>Data Ida</th>
								<th>Destino</th>
								<th>Data Volta</th>	
								<th>Hospedagem</th>
								<th>Bagagem</th>
								<th>Kg</th>
								<th>Locação</th>
								<th>Ações</th>																
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Origem</th>
								<th>Data Ida</th>
								<th>Destino</th>
								<th>Data Volta</th>	
								<th>Hospedagem</th>
								<th>Bagagem</th>
								<th>Kg</th>
								<th>Locação</th>
								<th>Ações</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($solicitacao->viagem as $viagem)
							<tr>
								<td></td>
								<td>{{$viagem->origem}}</td>
								<td>{{date('d/m/y',strtotime($viagem->data_ida))}}</td>
								<td>{{$viagem->destino}}</td>
								<td>{{date('d/m/y',strtotime($viagem->data_volta))}}</td>
								<td>{{$viagem->hospedagem == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$viagem->bagagem == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$viagem->kg}}</td>
								<td>{{$viagem->locacao == 1 ? 'SIM' : 'NÃO'}}</td>					
								<td>
									<div class="icon-button-demo" >
										<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#modal{{$viagem->id}}" role="button"><i class="material-icons">settings</i></a>

										<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('viagem.deletarViagem', $viagem->id)}}"><i class="material-icons">delete_sweep</i></a>
									</div>

								</td>
							</tr>


							<!-- MODAL TRANSLADO -->
							<div class="modal fade" id="modal{{$viagem->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Editar um Antecipação</h4>
										</div>

										<!-- INCIO SESSÃO TRANSLADO -->
										<form action="{{ route('viagem.atualizarViagem',$viagem->id)}}" method="POST">
											{{ csrf_field() }}
											{{ method_field('PUT') }}
											<div class="modal-body">				

												{{ csrf_field() }}
												{{ method_field('PUT') }}
												<div class="row clearfix">
													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="origem">Origem</label>
																<input type="text" value="{{$viagem->origem}}" name="origem" class="form-control" placeholder="Cidade de origem" required />										
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="data_ida">Data Ida</label>
																<input type="text" value="{{$viagem->data_ida}}" name="data_ida" class="datetimepicker form-control" placeholder="Data Obrigatória" required/>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="destino">Destino</label>
																<input type="text" value="{{$viagem->destino}}" name="destino" class="form-control" placeholder="Cidade de DEstino" required/>										
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="data_volta">Data Volta</label>
																<input type="text" value="{{$viagem->data_volta}}" name="data_volta" class="datetimepicker form-control" placeholder="Data Opcional"/>
															</div>
														</div>
													</div>

													<div class="col-md-2">
														<div class="form-group">
															<fieldset>
																<legend style="margin: 0">Locação</legend>
															</fieldset>
															<input name="locacao" value="1" type="radio" id="simLM" {{$viagem->locacao == 1 ? 'checked' : ''}} />
															<label style="margin: 15px 15px 0px 0px" for="simLM">Sim</label>
															<input name="locacao" value="0" type="radio" id="naoLM" {{$viagem->locacao == 0 ? 'checked' : ''}} />
															<label style="margin: 15px 15px 0px 0px" for="naoLM">Não</label>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<fieldset>
																<legend style="margin: 0">Hospedagem</legend>
															</fieldset>
															<input name="hospedagem" value="1" type="radio" id="simHM" {{$viagem->hospedagem == 1 ? 'checked' : ''}}/>
															<label style="margin: 15px 15px 0px 0px" for="simHM">Sim</label>
															<input name="hospedagem" value="0" type="radio" id="naoHM" checked {{$viagem->hospedagem == 0 ? 'checked' : ''}} />
															<label style="margin: 15px 15px 0px 0px" for="naoHM">Não</label>
														</div>
													</div>

												</div>
												<div class="row clearfix">
													<div class="col-md-2">
														<div class="form-group">
															<fieldset>
																<legend>Bagagem</legend>
															</fieldset>
															<input name="bagagem" value="1" type="radio" id="simBM" {{$viagem->bagagem == 1 ? 'checked' : ''}}/>
															<label style="margin: 15px 15px 0px 0px" for="simBM">Sim</label>
															<input name="bagagem" value="0" type="radio" id="naoBM" {{$viagem->bagagem == 0 ? 'checked' : ''}} />
															<label style="margin: 15px 15px 0px 0px" for="naoBM">Não</label>
														</div>
													</div>

													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="kg">Kg</label>
																<input type="text" value="{{$viagem->kg}}" name="kg" class="form-control" placeholder="Kilos"/>
															</div>
														</div>								
													</div>
													<div class="col-md-2" style="margin-top: 20px">
														<button class="btn bg-deep-orange waves-effect">
															<i class="material-icons">save</i>
															<span>Atualizar Viagem</span> 
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
							<!-- FIM MODAL TRANSLADO -->
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div> 												
</div>
<!-- FIM LISTAGEM DA ANTECIPAÇÃO -->
</section>
@endsection
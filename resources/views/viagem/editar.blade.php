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
	@if($solicitacao->status[0]->descricao =="ABERTO" || $solicitacao->status[0]->descricao =="DEVOLVIDO") 
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<!-- <h2>Cabecalho da Viagem</h2> -->
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#modalViagem" class="btn bg-light-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>VIAGEM</span>
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
	
	@else 
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<!-- <h2>Cabecalho da Viagem</h2> -->
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#modalDespesa" class="btn bg-light-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>ADICIONAR DESPESA</span>
						</a>
						@if($solicitacao->despesa->count() == 0)
						<a href="{{ route('solicitacao.finalizar', $solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
							<i class="material-icons">done_all</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>FINALIZAR</span>
						</a>
						@else
						<a href="{{ route('solicitacao.andamento', $solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
							<i class="material-icons">send</i>
							<span>ENVIAR</span>
						</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- MODAL DESPESA -->
	<div class="modal fade" id="modalDespesa" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione uma Despesa</h4>
				</div>
				<!-- INCIO SESSÃO DESPESA -->
				<div class="modal-body">
					<form action="{{ route('viagem.addDespesa',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="body">
							<div class="row clearfix">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="card">
										<div class="header">
											<h2>
												Preencha os campos abaixo com atenção
											</h2>
										</div>
										<div class="body">
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
													<b>Valor</b>
													<div class="input-group">
														<span class="input-group-addon">
															R$
														</span>
														<div class="form-line">
															<input type="numeric" id="valor" name="valor" class="form-control valor" placeholder="" required/>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<div class="form-line">
															<label for="anexo_comprovante">Envie um Arquivo</label>
															<input type="file" name="anexo_comprovante" id="anexo_comprovante" required/>
															<!-- <button type="reset" id="pseudoCancel">
																Resetar
															</button> -->
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<div class="form-group">
												<button class="btn btn-info">
													<i class="material-icons">save</i>
													<span>ADD DESPESA</span>
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
	<!-- FIM MODAL DESPESA -->

	<!-- INCIO CABEÇALHO PADRAO -->
	@include('layouts._includes.cabecalho._cabecalho_analise')
	<!-- FIM CABEÇALHO PADRAO -->
	@endif
	
	<!-- LISTAGEM DA VIAGEM  -->
	@include('layouts._includes._comentario')
	<!-- FIM LISTAGEM DA VIAGEM  -->
	@if($solicitacao->status[0]->descricao =="ABERTO" || $solicitacao->status[0]->descricao =="DEVOLVIDO")
	
	<!-- MODAL VIAGEM -->
	<div class="modal fade" id="modalViagem" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione um Translado</h4>
				</div>
				<!-- INCIO SESSÃO VIAGEM -->
				<div class="modal-body">
					<form action="{{ route('viagem.addViagem',$solicitacao->id)}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}			
						<div class="body">
							<div class="row clearfix">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="card">
										<div class="header">
											<h2>
												Preencha os campos abaixo com atenção
											</h2>
										</div>
										<div class="body">
											<div class="row clearfix">
												<div class="col-md-2">
													<div class="form-group">
														<div class="form-line">
															<label for="origem">Origem</label>
															<input type="text" value="" name="origem" class="form-control" placeholder="Cidade de Origem" required />										
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<div class="form-line">
															<label for="data_ida">Data Ida</label>
															<input type="text" value="" name="data_ida" class="ida form-control" placeholder="Data Obrigatória" required/>
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<div class="form-line">
															<label for="destino">Destino</label>
															<input type="text" value="" name="destino" class="form-control" placeholder="Cidade de Destino" required/>										
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<div class="form-line">
															<label for="data_volta">Data Volta</label>
															<input type="text" value="" name="data_volta" class="volta form-control" placeholder="Data Opcional"/>
														</div>
													</div>
												</div>

												<div class="col-md-2">
													<div class="form-group">
														<fieldset>
															<legend style="margin: 0">Locação de Carro</legend>
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
												<!-- <div class="col-md-2" style="margin-top: 20px">
													<button class="btn bg-deep-orange waves-effect">
														<i class="material-icons">save</i>
														<span>ADD VIAGEM</span> 
													</button>
												</div>	 -->						
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="form-group">
								<button class="btn btn-info">
									<i class="material-icons">save</i>
									<span>ADD VIAGEM</span>
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
	<!-- FIM MODAL VIAGEM -->
	
	@endif

	<!-- SESSÃO CADASTRO DA VIAGEM -->
	<!-- <div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Adicione uma Passagem a sua Solicitação
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
										<input type="text" value="" name="origem" class="form-control" placeholder="Cidade de Origem" required />										
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_ida">Data Ida</label>
										<input type="text" value="" name="data_ida" class="ida form-control" placeholder="Data Obrigatória" required/>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="destino">Destino</label>
										<input type="text" value="" name="destino" class="form-control" placeholder="Cidade de Destino" required/>										
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_volta">Data Volta</label>
										<input type="text" value="" name="data_volta" class="volta form-control" placeholder="Data Opcional"/>
									</div>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend style="margin: 0">Locação de Carro</legend>
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
					</form>	
				</div>
			</div>			
		</div>			
	</div> -->


	<!-- LISTAGEM DAS VIAGENS  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DAS VIAGENS
					</h2>
				</div>
				<div class="body">
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
							@foreach ($solicitacao->viagem as $key => $viagem)
							<tr>
								<td></td>
								<td>{{$viagem->origem}}</td>
								<td>{{date('d-m-Y H:m',strtotime($viagem->data_ida))}}</td>
								<td>{{$viagem->destino}}</td>
								@if($viagem->data_volta)
								<td>{{date('d-m-Y H:m',strtotime($viagem->data_volta))}}</td>
								@else
								<td>SOMENTE IDA</td>
								@endif
								<td>{{$viagem->hospedagem == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$viagem->bagagem == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$viagem->kg}}</td>
								<td>{{$viagem->locacao == 1 ? 'SIM' : 'NÃO'}}</td>					
								<td class="acoesTD">
									@if($solicitacao->status[0]->descricao =="ABERTO" || $solicitacao->status[0]->descricao =="DEVOLVIDO")
									<div class="icon-button-demo" >
										<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#modal{{$viagem->id}}" role="button"><i class="material-icons">settings</i></a>

										<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('viagem.deletarViagem', $viagem->id)}}"><i class="material-icons">delete_sweep</i></a>
									</div>
									@else
									@if($viagem->viagens_comprovantes_id == null)
									<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" disabled>
										<i class="material-icons">photo_library</i>
									</a>
									@else
									<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" onclick="openModal();currentSlide({{$key}})">
										<i class="material-icons">photo_library</i>
									</a>
									@endif
									@endif
								</td>
							</tr>

							@if($viagem->viagens_comprovantes_id == null)
							<!-- MODAL ATUALIZAÇÂO VIAGEM -->
							<div class="modal fade" id="modal{{$viagem->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Editar Viagem</h4>
										</div>

										<!-- INCIO SESSÃO ATUALIZAÇÂO DA VIAGEM -->
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
																<input type="text" value="{{$viagem->origem}}" name="origem" class="form-control" placeholder="Cidade de Origem" required />										
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="data_ida">Data Ida</label>
																<input type="text" value="{{date('d-m-Y H:m:00',strtotime($viagem->data_ida))}}" name="data_ida" class="ida form-control" placeholder="Data Obrigatória" required/>
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="destino">Destino</label>
																<input type="text" value="{{$viagem->destino}}" name="destino" class="form-control" placeholder="Cidade de Destino" required/>										
															</div>
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="data_volta">Data Volta</label>
																<input type="text" value="{{$viagem->data_volta != null ? date('d-m-Y H:m:00',strtotime($viagem->data_volta)) : ''}}" name="data_volta" class="volta form-control" placeholder="Data Opcional"/>
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
															<input name="hospedagem" value="0" type="radio" id="naoHM" {{$viagem->hospedagem == 0 ? 'checked' : ''}} />
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
													<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
												</div>
											</div>
										</form>	
									</div>
								</div>
							</div>
							<!-- FIM MODAL VIAGEM -->.
							@endif
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div> 												
	</div>
	<!-- FIM LISTAGEM DA VIAGENS -->
	
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
										<a href="{{ route('viagem.editarDespesa', $despesa->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">settings</i>
										</a>

										<a style="margin: 0px 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{route('viagem.deletarDespesa',$despesa->id)}}">
											<i class="material-icons">delete_sweep</i>
										</a>
										<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" onclick="openModal();currentSlide({{$key}})">
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
	<!-- FIM LISTAGEM DAS DESPESAS -->
	<!-- MODAL GALERIA -->
	<div id="myModal" class="modal-2">
		<span class="close-2 cursor" onclick="closeModal()">&times;</span>
		<div class="modal-content-2">

			@foreach ($solicitacao->viagem as $key => $viagem)
			@if($viagem->viagens_comprovantes_id != null)
			
			@if($viagem->comprovante->anexo_passagem != null)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label bg-teal">{{$viagem->origem}}</span> x <span class="label bg-green">{{$viagem->destino }} </span> <span class="label label-danger"> Passagem</span></h3></div>
				<img src="{{$viagem->comprovante->anexo_passagem}}" style="width:100%; max-height: 70%">
			</div>
			@endif

			@if($viagem->comprovante->anexo_hospedagem != null)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label bg-teal">{{$viagem->origem}}</span> x <span class="label bg-green">{{$viagem->destino }} </span> 
					<span class="label label-warning"> Hospedagem</span> </h3>
				</div>
				<img src="{{$viagem->comprovante->anexo_hospedagem}}" style="width:100%; max-height: 70%">
			</div>
			@endif

			@if($viagem->comprovante->anexo_locacao != null)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label label-info">{{$viagem->origem}} x {{$viagem->destino}} Locação</span></h3></div>
				<img src="{{$viagem->comprovante->anexo_locacao}}" style="width:100%; max-height: 70%">
			</div>
			@endif

			@endif	
			@endforeach		
			
			@foreach ($solicitacao->despesa as $despesa)
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
			
			<!-- @foreach ($solicitacao->despesa as $key => $despesa)
			<div class="column">
				<img class="demo cursor" src="{{$despesa->anexo_comprovante}}" style="width:100%" onclick="currentSlide({{$key}})" alt="{{$despesa->descricao}}">
			</div>

			@endforeach -->

		</div>
	</div>
	<!-- FIM MODAL GALERIA -->
</section>
@endsection
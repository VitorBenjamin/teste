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
					<h2>Dados da Guia</h2>
				</div>
				<form action="{{ route('guia.atualizarCabecalho',$solicitacao->id)}}" method="POST">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					@include('layouts._includes.cabecalho._cabecalho-editar')
				</form>
			</div>
		</div>
	</div>
	<!-- FIM CABEÇALHO PADRAO -->

	<!-- SESSÃO CADASRO DA GUIA -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Dados Da Guia
					</h2>
				</div>
				<div class="body">
					<form action="{{ route('guia.addGuia',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="row clearfix">
							
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_limite">Data</label>
										<input type="text" value="" name="data_limite" class="datepicker form-control" placeholder="Escolha uma Data" required />
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="reclamante">Reclamante</label>
										<input type="text" value="" name="reclamante" class="form-control" placeholder="Nome do Reclamante" required/>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="valor_solicitado">Valor</label>
										<input type="text" value="" name="valor_solicitado" class="form-control" placeholder="R$." required/>
									</div>
								</div>								
							</div>

							<div class="col-md-2">
								<label for="perfil_pagamento">Perfil Pagamento</label>
								<select id="perfil_pagamento" name="perfil_pagamento" class="form-control show-tick" required>
									<option value="BOLETO">BOLETO</option>										
									<option value="DAF">DAF</option>
									<option value="DMA">DAM</option>
									<option value="GRU">GRU</option>
									<option value="GFIP">GFIP</option>
								</select>
							</div>

							<div class="col-md-2">
								<label for="banco">Banco</label>
								<select id="banco" name="banco" class="form-control show-tick" required>
									<option value="BANCO DO BRASIL">BANCO DO BRASIL</option>										
									<option value="ITAU">ITAU</option>
									<option value="BRADESCO">BRADESCO</option>								
								</select>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend style="margin: 0">Prioridade</legend>
									</fieldset>
									<input name="prioridade" value="1" type="radio" id="simP" />
									<label style="margin: 15px 15px 0px 0px" for="simP">Sim</label>
									<input name="prioridade" value="0" type="radio" id="naoP" checked />
									<label style="margin: 15px 15px 0px 0px" for="naoP">Não</label>
								</div>
							</div>

							<div class="col-md-3">
								<label for="tipo_guias_id">Tipo</label>
								<select id="tipo_guias_id" name="tipo_guias_id" class="form-control show-tick" data-live-search="true" data-size="5" required>
									@foreach($tipo_guia as $grupo => $tipo)
									<optgroup label="{{$grupo}}">
										@foreach($tipo as $desc)
										<option value="{{$desc->id}}">{{$desc->descricao}}</option>
										@endforeach	
									</optgroup>
									@endforeach						
								</select>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<div class="form-line">
										<label for="anexo_pdf">Anexar PDF</label>
										<input style="margin-top: 10px " type="file" name="anexo_pdf" id="anexo_pdf" required/>
									</div>
								</div>								
							</div>	

							<div class="col-md-2" style="margin-top: 20px">
								<button class="btn bg-light-green waves-effect">
									<i class="material-icons">save</i>
									<span>ADD GUIA</span> 
								</button>
							</div>
						</div>
					</form>	
				</div>			
			</div>			
		</div>
	</div>
	<!-- FIM SESSÃO DA GUIA -->

	<!-- LISTAGEM DA GUIA  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTA DA GUIA
					</h2>
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped nowrap table-hover dataTable js-basic-example ">
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
									<th>PDF</th>
									<th>Ações</th>																	
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
									<th>PDF</th>
									<th>Ações</th>
								</tr>
							</tfoot>
							<tbody> 
								@foreach ($solicitacao->guia as $guia)
								<tr>
									<td></td>
									<td>{{date('d/m/y',strtotime($guia->data_limite))}}</td>
									<td>{{ $guia->prioridade == 1 ? 'SIM' : 'NÃO' }}</td>
									<td>{{$guia->reclamante}}</td>									
									<td>{{$guia->perfil_pagamento}}</td>
									<td>{{$guia->banco}}</td>
									<td>{{$guia->tipoGuia()->first()->tipo}}</td>
									<td>{{$guia->tipoGuia()->first()->descricao}}</td>
									<td><a target="_blank" href="{{URL::to('storage/guias/'.$guia->anexo_pdf)}}" class="btn btn-primary waves-effect">
										<i class="material-icons">file_download</i>BAIXAR PDF</a>
									</td>
									<td>
										<div class="icon-button-demo" >
											<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#modal{{$guia->id}}" class="waves-effect" role="button"><i class="material-icons">settings</i></a>
											
											<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('guia.deletarGuia', $guia->id)}}"><i class="material-icons">delete_sweep</i></a>

										</div>
									</td>
								</tr>


								<!-- MODAL TRANSLADO -->
								<div class="modal fade" id="modal{{$guia->id}}" tabindex="-1" role="dialog">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="largeModalLabel">Editar um Guia</h4>
											</div>

											<!-- INCIO SESSÃO TRANSLADO -->
											<form action="{{ route('guia.atualizarGuia',$guia->id)}}" method="POST">
												{{ csrf_field() }}
												{{ method_field('PUT') }}
												<div class="modal-body">				

													<div class="row clearfix">

														<div class="col-md-2">
															<div class="form-group">
																<div class="form-line">
																	<label for="data_limite">Data</label>
																	<input type="text" value="{{$guia->data_limite}}" name="data_limite" class="datepicker form-control " placeholder="Escolha uma Data"/>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<div class="form-line">
																	<label for="reclamante">Reclamante</label>
																	<input type="text" value="{{$guia->reclamante}}" name="reclamante" class="form-control" placeholder="Nome do Reclamante"/>
																</div>
															</div>
														</div>

														<div class="col-md-2">
															<div class="form-group">
																<div class="form-line">
																	<label for="valor_solicitado">Valor</label>
																	<input type="text" value="{{$guia->perfil_pagamento}}" name="valor_solicitado" class="form-control" placeholder="R$."/>
																</div>
															</div>								
														</div>

														<div class="col-md-2">
															<label for="perfil_pagamento">Perfil Pagamento</label>
															<select id="perfil_pagamento" name="perfil_pagamento" class="form-control show-tick">
																<option value="{{$guia->perfil_pagamento}}">{{$guia->perfil_pagamento}}</option>
																<option value="BOLETO">BOLETO</option>										
																<option value="DAF">DAF</option>
																<option value="DMA">DAM</option>
																<option value="GRU">GRU</option>
																<option value="GFIP">GFIP</option>
															</select>
														</div>

														<div class="col-md-2">
															<label for="banco">Banco</label>
															<select id="banco" name="banco" class="form-control show-tick">
																<option value="{{$guia->banco}}">{{$guia->banco}}</option>
																<option value="BANCO DO BRASIL">BANCO DO BRASIL</option>		
																<option value="ITAU">ITAU</option>
																<option value="BRADESCO">BRADESCO</option>								
															</select>
														</div>

														<div class="col-md-2">
															<div class="form-group">
																<fieldset>
																	<legend style="margin: 0">Prioridade</legend>
																</fieldset>
																<input name="prioridade" value="1" type="radio" id="simP" 
																{{$guia->prioridade == 1 ? 'checked' : '' }}/>
																<label style="margin: 15px 15px 0px 0px" for="simP">Sim</label>
																<input name="prioridade" value="0" type="radio" id="naoP" 
																{{$guia->prioridade == 0 ? 'checked' : '' }}/>
																<label style="margin: 15px 15px 0px 0px" for="naoP">Não</label>
															</div>
														</div>

														<div class="col-md-3">
															<label for="tipo_guias_id">Tipo</label>
															<select id="tipo_guias_id" name="tipo_guias_id" class="form-control show-tick" data-live-search="true" data-size="5">
																@foreach($tipo_guia as $grupo => $tipo)
																<optgroup label="{{$grupo}}">
																	@foreach($tipo as $desc)
																	<option value="{{$desc->id}}" {{$guia->tipoGuia()->first()->id == $desc->id ? 'selected' : '' }}>{{$desc->descricao}}</option>
																	@endforeach	
																</optgroup>
																@endforeach						
															</select>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<div class="form-line">
																	<label for="anexo_pdf">Anexar PDF</label>
																	<input style="margin-top: 10px " type="file" name="anexo_pdf" id="anexo_pdf" />
																</div>
															</div>								
														</div>	

														<div class="col-md-2" style="margin-top: 20px">
															<button class="btn bg-light-green waves-effect">
																<i class="material-icons">save</i>
																<span>ADD GUIA</span> 
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
								<!-- FIM MODAL EDIÇÂO DA GUIA -->
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
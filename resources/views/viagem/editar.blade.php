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
	@if($solicitacao->status[0]->descricao =="ABERTO" || $solicitacao->status[0]->descricao =="DEVOLVIDO" || $solicitacao->status[0]->descricao =="COORDENADOR-ABERTO") 
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
						{{-- <a href="{{ route('solicitacao.finalizar', $solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
							<i class="material-icons">done_all</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>FINALIZAR</span>
						</a> --}}
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
														<option value="OUTROS">OUTROS</option>
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
															<input type="numeric" name="valor" style="text-align:right" name="valor" class="form-control" size="11" onKeyUp="moeda(this);" required>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<div class="form-line">
															<label for="anexo_comprovante">Envie um Arquivo (JPG)</label>
															<input type="file" name="anexo_comprovante" id="anexo_comprovante" accept="image/jpeg" required/>
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
	
	<!-- SESSÂO COMENTÁRIO -->
	@if(count($solicitacao->comentarios) > 0)
	@include('layouts._includes._comentario')
	@endif
	<!-- FIM SESSÂO COMENTÁRIO  -->

	@if($solicitacao->status[0]->descricao =="ABERTO" || $solicitacao->status[0]->descricao =="DEVOLVIDO" || $solicitacao->status[0]->descricao =="COORDENADOR-ABERTO")

	<!-- MODAL VIAGEM -->
	<div class="modal fade" id="modalViagem" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione uma Viagem</h4>
				</div>
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
															<input type="text" value="" name="data_ida" class="datepicker form-control" placeholder="Data Obrigatória" required/>
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
															<input type="text" value="" name="data_volta" class="datepicker form-control" placeholder="Data Opcional"/>
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<fieldset>
															<legend>Translado</legend>
														</fieldset>
														<input name="translado" value="1" type="radio" id="simT" />
														<label style="margin: 15px 15px 0px 0px" for="simT">Sim</label>
														<input name="translado" value="0" type="radio" id="naoT" checked/>
														<label style="margin: 15px 15px 0px 0px" for="naoT">Não</label>
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
												<div class="col-md-6">
													<div class="form-group">
														<div class="form-line">
															<label for="observacao">Observação</label>
															<input type="text" value="" name="observacao" class="form-control" placeholder="Obs.."/>
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
	
	@if(count($solicitacao->viagem) > 0)
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
					@foreach ($solicitacao->viagem as $key => $viagem)
					<table class="table table-bordered table-striped nowrap table-hover dataTable table-simples">
						<thead>
							<tr>
								<th></th>
								<th>Origem</th>
								<th>Data Ida</th>
								<th>Destino</th>
								<th>Data Volta</th>
								<th>Translado</th>	
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
								<th>Translado</th>
								<th>Hospedagem</th>
								<th>Bagagem</th>
								<th>Kg</th>
								<th>Locação</th>
								<th>Ações</th>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<td></td>
								<td>{{$viagem->origem}}</td>
								<td>{{date('d/m/Y',strtotime($viagem->data_ida))}}</td>
								<td>{{$viagem->destino}}</td>
								<td>{{$viagem->data_volta ? date('d/m/Y',strtotime($viagem->data_volta)) : 'SÓ IDA'}}</td>
								<td>{{$viagem->translado ? 'SIM' : 'NÃO'}}</td>
								<td>
									{{$viagem->hospedagem == 1 ? 'SIM' : 'NÃO'}}
								</td>
								<td>{{$viagem->bagagem == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$viagem->kg}}</td>
								<td>
									{{$viagem->locacao == 1 ? 'SIM' : 'NÃO'}}
								</td>

								<td class="acoesTD">									
									<div class="icon-button-demo" >
										@role('ADMINISTRATIVO')
										@if ($solicitacao->status[0]->descricao == "ABERTO" || $solicitacao->status[0]->descricao == "DEVOLVIDO" || $solicitacao->status()->get()[0]->descricao == config('constantes.status_recorrente_financeiro'))
										<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#addCotacao{{$viagem->id}}"><i class="material-icons">local_atm</i></a>
										@elseif($solicitacao->status[0]->descricao =="APROVADO")
										<a class="btn bg-blue btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#addComprovante{{$viagem->id}}"><i class="material-icons">link</i></a>
										@endif
										@endrole
										<a href="{{ route('viagem.editarViagem', $viagem->id)}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float"><i class="material-icons">edit</i></a>

										<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('viagem.deletarViagem', $viagem->id)}}"><i class="material-icons">delete_sweep</i></a>
									</div>
									@if($viagem->anexo_comprovante)
									<div class="zoom-gallery">
										<a href="{{$viagem->anexo_comprovante}}" data-source="{{$viagem->anexo_comprovante}}" title="COMPROVANTE - {{$viagem->tipo_comprovante}} - {{date('d/m/Y',strtotime($viagem->data_compra))}}" style="width:32px;height:32px;">
											<img class="img_popup" src="{{$viagem->anexo_comprovante}}" width="32" height="32">
										</a>
									</div>
									@endif
								</td>	
							</tr>
						</tbody>
					</table>
					@include('viagem.cotacao')
					@include('viagem.comprovante')
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-2" style="margin: 30px 0 0 0;">
								<h4>Passagem <i class="material-icons">trending_flat</i></h4>
							</div>
							<div class="col-md-10">
								@if($viagem->valor)
								<table class="table table-bordered table-striped nowrap table-hover dataTable table-simples">
									<thead>
										<tr>
											<th></th>
											<th>Data Cotação</th>
											<th>Observação</th>
											<th>Data Compra</th>
											<th>Valor</th>
											<th>Comprovante</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td>{{$viagem->data_cotacao ? date('d-m-Y', strtotime($viagem->data_cotacao)) : ''}}</td>
											<td>{{$viagem->observacao_comprovante ? $viagem->observacao_comprovante : 'SEM OBSERVAÇÃO'}}</td>
											<td>{{$viagem->data_compra ? date('d-m-Y', strtotime($viagem->data_compra)) : 'ANDAMENTO'}}</td>
											<td>R$ {{$viagem->valor}}</td>
											<td>
												@if($viagem->anexo_passagem)
												<div class="zoom-gallery">
													<a href="{{$viagem->anexo_passagem}}" data-source="{{$viagem->anexo_passagem}}" title="COMPROVANTE - {{$viagem->tipo_comprovante}} - {{date('d/m/Y',strtotime($viagem->data_compra))}}" style="width:32px;height:32px;">
														<img class="img_popup" src="{{$viagem->anexo_passagem}}" width="32" height="32">
													</a>
												</div>
												@endif
											</td>
										</tr>
									</tbody>
								</table>
								@endif
							</div>
						</div>
					</div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-2" style="margin: 30px 0 0 0;">
								<h4>Hospedagem <i class="material-icons">trending_flat</i></h4>
							</div>
							<div class="col-md-10">
								@if($viagem->hospedagens)

								<table class="table table-bordered table-striped nowrap table-hover dataTable table-simples">
									<thead>
										<tr>
											<th></th>
											<th>Data Cotação</th>
											<th>Observação</th>
											<th>Data Compra</th>
											<th>Valor</th>
											<th>Comprovante</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td>{{$viagem->hospedagens->data_cotacao ? date('d-m-Y', strtotime($viagem->hospedagens->data_cotacao)) : ''}}</td>
											<td>{{$viagem->hospedagens->observacao ? $viagem->hospedagens->observacao : 'SEM OBSERVAÇÃO'}}</td>
											<td>{{$viagem->hospedagens->data_compra ? date('d-m-Y', strtotime($viagem->hospedagens->data_compra)) : 'ANDAMENTO'}}</td>
											<td>R$ {{$viagem->hospedagens->custo_hospedagem}}</td>
											<td>
												<div class="zoom-gallery">
													@if($viagem->hospedagens->anexo_hospedagem)
													<a href="{{$viagem->hospedagens->anexo_hospedagem}}" data-source="{{$viagem->hospedagens->anexo_hospedagem}}" title="COMPROVANTE - {{$viagem->hospedagens->tipo_comprovante}} - {{date('d/m/Y',strtotime($viagem->hospedagens->data_compra))}}" style="width:32px;height:32px;">
														<img class="img_popup" src="{{$viagem->hospedagens->anexo_hospedagem}}" width="32" height="32">
													</a>
													@endif
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								@endif
							</div>
						</div>
					</div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-2" style="margin: 30px 0 0 0;">
								<h4>Locação <i class="material-icons">trending_flat</i></h4>
							</div>
							<div class="col-md-10">
								@if($viagem->locacoes)
								<table class="table table-bordered table-striped nowrap table-hover dataTable table-simples">
									<thead>
										<tr>
											<th></th>
											<th>Data Cotação</th>
											<th>Observação</th>
											<th>Data Compra</th>
											<th>Valor</th>
											<th>Comprovante</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td>{{$viagem->locacoes->data_cotacao ? date('d-m-Y', strtotime($viagem->locacoes->data_cotacao)) : ''}}</td>
											<td>{{$viagem->locacoes->observacao ? $viagem->locacoes->observacao : 'SEM OBSERVAÇÃO'}}</td>
											<td>{{$viagem->locacoes->data_compra ? date('d-m-Y', strtotime($viagem->locacoes->data_compra)) : 'ANDAMENTO'}}
											</td>
											<td>R$ {{$viagem->locacoes->valor}}</td>
											<td>
												<div class="zoom-gallery">
													@if($viagem->locacoes->anexo_locacao)
													<a href="{{$viagem->locacoes->anexo_locacao}}" data-source="{{$viagem->locacoes->anexo_locacao}}" title="COMPROVANTE - {{$viagem->locacoes->tipo_comprovante}} - {{date('d/m/Y',strtotime($viagem->locacoes->data_compra))}}" style="width:32px;height:32px;">
														<img class="img_popup" src="{{$viagem->locacoes->anexo_locacao}}" width="32" height="32">
													</a>
													@endif
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								@endif
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div> 												
	</div>
	<!-- FIM LISTAGEM DA VIAGENS -->
	@endif

	@if(count($solicitacao->despesa) > 0)
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
								<td>R$ {{$despesa->valor}}</td>
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a href="{{ route('viagem.editarDespesa', $despesa->id)}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">edit</i>
										</a>

										<a style="margin: 0px 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{route('viagem.deletarDespesa',$despesa->id)}}">
											<i class="material-icons">delete_sweep</i>
										</a>
										<div class="zoom-gallery" style="display: inline;">
											@if($despesa->anexo_comprovante)
											<a href="{{$despesa->anexo_comprovante}}" data-source="{{$despesa->anexo_comprovante}}" title="COMPROVANTE - {{$despesa->tipo_comprovante}} - {{date('d/m/Y',strtotime($despesa->data_despesa))}}" style="width:35px;height:35px;">
												<img class="img_popup" src="{{$despesa->anexo_comprovante}}" width="35" height="35">
											</a>
											@endif
										</div>
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
	@endif
</section>
@endsection
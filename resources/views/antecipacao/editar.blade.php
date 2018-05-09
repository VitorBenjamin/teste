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
	@if($solicitacao->status[0]->descricao == "ABERTO" || $solicitacao->status[0]->descricao == "DEVOLVIDO" || $solicitacao->status[0]->descricao =="COORDENADOR-ABERTO") 
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<!-- <h2>Cabecalho da antecipacao</h2> -->
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#modalAntecipacao" class="btn bg-light-green waves-effect" role="button" 
						{{!empty($solicitacao->antecipacao[0]) ? 'disabled' : ''}}>
						<i class="material-icons">exposure_plus_1</i>
						<span>ANTECIPAÇÂO</span></a>
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
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#modalDespesa" class="btn bg-light-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<span>ADICIONAR DESPESA</span>
						</a>
						<a href="{{ route('solicitacao.andamento', $solicitacao->id) }}" class="btn bg-teal waves-effect {{count($solicitacao->despesa) > 0 ? '' : 'not-active'}}" role="button" {{count($solicitacao->despesa) > 0 ? '' : 'disabled'}}>
							<i class="material-icons">send</i>
							<span>ENVIAR</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- INCIO CABEÇALHO PADRAO -->
	@include('layouts._includes.cabecalho._cabecalho_analise')
	
	<!-- FIM CABEÇALHO PADRAO -->
	@endif
	<!-- FIM CABEÇALHO PADRAO -->

	<!-- SESSÂO COMENTÁRIO -->
	@if(count($solicitacao->comentarios) > 0)
	
	@include('layouts._includes._comentario')
	
	@endif
	<!-- FIM SESSÂO COMENTÁRIO  -->

	@if(empty($solicitacao->antecipacao[0]))
	
	<!-- MODAL CADASTRO DA ANTECIPAÇÂO -->
	<div class="modal fade" id="modalAntecipacao" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione uma Antecipação</h4>
				</div>
				<!-- INCIO SESSÃO antecipacao -->
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
	@else

	<!-- LISTAGEM DA ANTECIPAÇÃO  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTA DAS ANTECIPAÇÕES
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped nowrap table-hover dataTable js-basic-example">
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
							@foreach ($solicitacao->antecipacao as $key => $antecipacao)
							<tr>
								<td></td>
								<td>{{date('d/m/Y',strtotime($antecipacao->data_recebimento))}}</td>
								<td>{{$antecipacao->descricao}}</td>
								<td>R$ {{$antecipacao->valor}}</td>									
								<td class="acoesTD">
									<div class="icon-button-demo" >
										@if ($solicitacao->status[0]->descricao == "ABERTO" || $solicitacao->status[0]->descricao == "DEVOLVIDO")
										<a class="btn bg-grey btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#modal{{$antecipacao->id}}" role="button"><i class="material-icons">edit</i>
										</a>
										<a style="margin: 0px 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('antecipacao.deletarAntecipacao', $antecipacao->id)}}"><i class="material-icons">delete_sweep</i>
										</a>
										@endif
										@if($antecipacao->anexo_comprovante)
										<div class="zoom-gallery" style="display: inline;">
											<a href="{{$antecipacao->anexo_comprovante}}" data-source="{{$antecipacao->anexo_comprovante}}" title="{{$antecipacao->descricao}} - {{date('d/m/Y',strtotime($antecipacao->data_recebimento))}}" style="width:35px;height:35px;">
												<img class="img_popup" src="{{$antecipacao->anexo_comprovante}}" width="35" height="35">
											</a>
										</div>
										@endif						
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
																<input type="text" value="{{$antecipacao->valor}}" name="valor" style="text-align:right" class="form-control" size="11" onKeyUp="moeda(this);" required/>
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
	
	@if (count($solicitacao->despesa) > 0)
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
					<table class="table table-bordered table-striped table-hover dataTable table-simples">
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
										<a href="{{ route('antecipacao.editarDespesa', $despesa->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">settings</i>
										</a>

										<a style="margin: 0px 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{route('antecipacao.deletarDespesa',$despesa->id)}}">
											<i class="material-icons">delete_sweep</i>
										</a>
										<div class="zoom-gallery" style="display: inline;">

											<a href="{{$despesa->anexo_comprovante}}" data-source="{{$despesa->anexo_comprovante}}" title="{{$despesa->tipo_comprovante}} - {{date('d/m/Y',strtotime($despesa->data_despesa))}}" style="width:35px;height:35px;">
												<img class="img_popup" src="{{$despesa->anexo_comprovante}}" width="35px" height="35px">
											</a>
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
	
	@endif
	@if ($solicitacao->status[0]->descricao == "ABERTO-ETAPA2" || $solicitacao->status[0]->descricao == "DEVOLVIDO-ETAPA2")
	
	<!-- MODAL DESPESA -->
	<div class="modal fade" id="modalDespesa" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione uma Despesa</h4>
				</div>
				<!-- INCIO SESSÃO DESPESA -->
				<div class="modal-body">
					<form action="{{ route('antecipacao.addDespesa',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
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
															<label for="anexo_comprovante">Envie um Arquivo (jpeg,png)</label>
															<input type="file" name="anexo_comprovante" id="anexo_comprovante" accept=".jpg,.png" required/>
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
	@endif
	
</section>
@endsection
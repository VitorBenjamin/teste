@extends('layouts.app')
@section('content')

<section class="content">
	<div class="block-header">
		<h2>Dados da Solicitação</h2>			
	</div>
	<!-- COMEÇO CABEÇALHO PADRÃO -->
	@if(Session::has('flash_message'))
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div align="center" class="alert {{ Session::get('flash_message')['class'] }}">
					{{ Session::get('flash_message')['msg'] }}

				</div>
			</div>
		</div>
	</div>
	@endif
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#modalTranslado" class="btn bg-primary waves-effect" role="button">ADD TRANSLADO</a>
						<a data-toggle="modal" data-target="#modalDespesa" class="btn bg-primary waves-effect" role="button">ADD DESPESA</a>
					</div>
				</div>
				<div class="body">
					<form action="{{ route('reembolso.atualizar',$solicitacao->id)}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="row clearfix">
							<div class="col-md-2">
								<label for="origem_despesa">Origem de Despesa</label>
								<select id="origem_despesa" name="origem_despesa" class="form-control show-tick">
									<option value="{{$solicitacao->origem_despesa}}">{{$solicitacao->origem_despesa}}</option>
									<option value="ESCRITÓRIO">ESCRITÓRIO</option>
									<option value="CLIENTE">CLIENTE</option>

								</select>
							</div>
							<div class="col-md-3">
								<label for="clientes_id">Cliente</label>
								<select id="clientes_id" name="clientes_id" class="form-control show-tick" data-live-search="true">
									@foreach ($clientes as $cliente)
									@if($solicitacao->clientes_id == $cliente->id)
									<option value="{{$solicitacao->clientes_id}}">{{ $cliente->nome }}</option>
									@break							
									@endif
									@endforeach
									<option value="">SELECIONE</option>
									
									@foreach ($clientes as $cliente)
									@unless ($solicitacao->clientes_id == $cliente->id)
									<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
									@endunless

									@endforeach
								</select>
							</div>
							<div class="col-md-3">
								<label for="solicitantes_id">Solicitante</label>
								<select id="solicitantes_id" name="solicitantes_id" class="form-control show-tick" data-live-search="true">
									@foreach ($solicitantes as $solicitante)
									@if($solicitacao->solicitantes_id == $solicitante->id)
									<option value="{{$solicitacao->solicitantes_id}}">{{ $solicitante->nome }}</option>
									@break							
									@endif
									@endforeach
									
									<option value="null">SELECIONE</option>
									
									@foreach ($solicitantes as $solicitante)
									@unless ($solicitacao->solicitantes_id == $solicitante->id)
									<option value="{{ $solicitante->id }}">{{ $solicitante->nome }}</option>
									@endunless												
									@endforeach
								</select>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<div class="form-line">
										<label for="processos_id">Número de Processo</label>
										<input type="text" id="processos_id" value="{{$solicitacao->processos_id}}" name="processos_id" class="form-control" placeholder="N°" />
									</div>
								</div>
							</div>
							
						</div>
						<div class="row clearfix">
							<div class="col-md-3">
								<label for="area_atuacoes_id">Área de Atendimento</label>
								<select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-live-search="true">									
									@foreach ($areas as $area)
									@if($solicitacao->area_atuacoes_id == $area->id)
									<option value="{{$solicitacao->area_atuacoes_id}}">{{ $area->tipo }}</option>
									@break							
									@endif
									@endforeach
									
									<option value="null">SELECIONE</option>
									
									@foreach ($areas as $area)
									@unless ($solicitacao->area_atuacoes_id == $area->id)
									<option value="{{ $area->id }}">{{ $area->tipo }}</option>
									@endunless												
									@endforeach
								</select>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="contrato">Tipo de Contrato</label>
									<select id="contrato" name="contrato" class="form-control show-tick" data-live-search="true">
										<option value="{{$solicitacao->contrato}}">{{$solicitacao->contrato}}</option>
										<option value="CONSULTIVO">CONSULTIVO</option>
										<option value="CONTECIOSO">CONTECIOSO</option>
										<option value="PREVENTIVO">PREVENTIVO</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend style="margin: 0">Urgência</legend>
									</fieldset>
									@if ($solicitacao->urgente == true)
									<input name="urgente" value="1" type="radio" id="sim" checked />
									<label style="margin: 17px 5px" for="sim">Sim</label>
									<input name="urgente" value="0" type="radio" id="nao" />
									<label style="margin: 17px 5px" for="nao">Não</label>
									@else
									<input name="urgente" value="1" type="radio" id="sim" />
									<label style="margin: 17px 5px" for="sim">Sim</label>
									<input name="urgente" value="0" type="radio" id="nao" checked />
									<label style="margin: 17px 5px" for="nao">Não</label>
									@endif
								</div>
							</div>																	
						</div>
						<div class="form-group">
							<button class="btn btn-info">
								<i class="material-icons">save</i>
								<span>ATUALIZAR CABEÇALHO</span> 
							</button>
						</div>
					</form> 
				</div>
			</div>
		</div>
	</div>
	<!-- FIM CABEÇALHO PADRAO -->

	<!-- LISTAGEM DOS TRANSLADOS  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DOS TRANSLADOS
					</h2>
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped nowrap table-hover dataTable js-basic-example ">
							<thead>
								<tr>
									<th></th>
									<th>Data</th>
									<th>Origem</th>
									<th>Destino</th>
									<th>Ida/Volta</th>
									<th>Distância</th>
									<th>Ações</th>										
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th></th>
									<th>Data</th>
									<th>Origem</th>
									<th>Destino</th>
									<th>Ida/Volta</th>
									<th>Distância</th>
									<th>Ações</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach ($solicitacao->translado as $translado)
								<tr>
									<td></td>
									<td>{{date('d/m/y',strtotime($translado->data_translado))}}</td>
									<td>{{$translado->origem}}</td>
									<td>{{$translado->destino}}</td>
									@if($translado->ida_volta)
									<td>SIM</td>
									@else
									<td>NÂO</td>
									@endif
									<td>{{$translado->distancia}}</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="material-icons">settings</i>
											</button>
											<ul class="dropdown-menu">
												<li><a href="{{ route('reembolso.editarTranslado', $translado->id)}}">Editar</a></li>
												<li><a href="{{ route('reembolso.deletarTranslado', $translado->id)}}">Deletar</a></li>												
											</ul>
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
	</div>
	<!-- FIM LISTAGEM DOS TRANSLADOS -->

	<!-- LISTAGEM DAS DESPESAS  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DOS DESPESAS
					</h2>
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover dataTable js-exportable">
							<thead>
								<tr>
									<th>Data</th>
									<th>Descricao</th>
									<th>Comprovante</th>
									<th>Valor</th>
									<th>Ação</th>										
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Data</th>
									<th>Descricao</th>
									<th>Comprovante</th>
									<th>Valor</th>
									<th>Ação</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach ($solicitacao->despesa as $despesa)
								<tr>
									<td>{{date('d/m/y',strtotime($despesa->data_despesa))}}</td>
									<td>{{$despesa->descricao}}</td>
									<td>{{$despesa->tipo_comprovante}}</td>
									<td>{{$despesa->valor}}</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="material-icons">settings</i>
											</button>
											<ul class="dropdown-menu">
												<li><a href="{{ route('reembolso.editarDespesa', $despesa->id)}}">Editar</a></li>
												<li><a href="{{ route('reembolso.deletarDespesa', $despesa->id)}}">Deletar</a></li>												
											</ul>
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
	</div>
	<!-- FIM LISTAGEM DOS DESPESAS -->

	<!-- MODAL TRANSLADO -->
	<div class="modal fade" id="modalTranslado" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione um Translado</h4>
				</div>

				<!-- INCIO SESSÃO TRANSLADO -->

				<div class="modal-body">
					<form action="{{ route('reembolso.addTranslado',$solicitacao->id)}}" method="post" enctype="multipart/form-data">
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
												<div class="col-sm-2">
													<div class="form-group">
														<div class="form-line">
															<label for="data_translado">Data</label>
															<input type="text" name="data_translado" class="datepicker form-control" placeholder="Escolha uma Data"/>
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<label for="turno">Turno</label>
													<select id="turno" name="turno" class="form-control show-tick" data-live-search="true">
														<option value="">SELECIONE</option>
														<option value="MATUTINO">MATUTINO</option>
														<option value="VESPERTINO">VESPERTINO</option>
													</select>
												</div>

												<div class="col-md-2">
													<div class="form-group">
														<div class="form-line">
															<label for="origem">Origem</label>
															<input type="text" name="origem" class="form-control" placeholder=""/>										
														</div>
													</div>
												</div>

												<div class="col-md-2">
													<div class="form-group">
														<div class="form-line">
															<label for="destino">Destino</label>
															<input type="text" name="destino" class="form-control" placeholder=""/>
														</div>
													</div>								
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<div>
															<fieldset>
																<legend>Ida / Volta</legend>
															</fieldset>
															<input name="ida_volta" value="1" type="radio" id="ida_volta_sim" />
															<label style="margin: 15px" for="ida_volta_sim">Sim</label>
															<input name="ida_volta" value="0" type="radio" id="ida_volta_nao" checked/>
															<label style="margin: 15px" for="ida_volta_nao">Não</label>
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<div class="form-line">
															<label for="distancia">Distância (KM)</label>
															<input type="text" name="distancia" class="form-control" placeholder=""/>
														</div>
													</div>								
												</div>
												<div class="col-sm-12">
													<div class="form-group">
														<div class="form-line">
															<textarea rows="3" name="observacao" class="form-control no-resize" placeholder="Campo para deixar uma Observação"></textarea>
														</div>
													</div>
												</div>
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
									<span>ADD TRANSLADO</span>
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
	<!-- FIM MODAL TRANSLADO -->

	<!-- MODAL DESPESA -->
	<div class="modal fade" id="modalDespesa" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione uma Despesa</h4>
				</div>

				<!-- INCIO SESSÃO DESPESA -->

				<div class="modal-body">
					<form action="{{ route('reembolso.addDespesa',$solicitacao->id)}}" method="post" enctype="multipart/form-data">
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
												<div class="col-sm-2">
													<div class="form-group">
														<div class="form-line">
															<label for="data_despesa">Data</label>
															<input type="text" name="data_despesa" class="datepicker form-control" placeholder="Escolha uma Data"/>
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<label for="tipo_comprovante">Comprovante</label>
													<select id="tipo_comprovante" name="tipo_comprovante" class="form-control show-tick">
														<option value="">SELECIONE</option>
														<option value="HOSPEDAGEM">HOSPEDAGEM</option>
														<option value="ALIMENTAÇÂO">ALIMENTAÇÃo</option>
														<option value="TRANSPORTE">TRANSPORTE</option>

													</select>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<div class="form-line">
															<label for="descricao">Descrição</label>
															<input type="text" name="descricao" class="form-control" placeholder=""/>										
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<div class="form-line">
															<label for="valor">Valor</label>
															<input type="text" id="valor" name="valor" class="form-control" placeholder=""/>
														</div>
													</div>								
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<div class="form-line">
															<label for="anexo_comprovante">Evie um Arquivo</label>
															<input type="file" name="anexo_comprovante" id="anexo_comprovante" />
															<button type="reset" id="pseudoCancel">
																Cancel
															</button>
														</div>
													</div>								
												</div>
												<div class="file-field input-field">
													<div class="btn">
														<span>File</span>
														<input type="file">
													</div>
													<div class="file-path-wrapper">
														<input class="file-path validate" type="text">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- FIM SESSÃO DESPESA -->
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
					</form> 
				</div>
			</div>
		</div>
	</div>
	<!-- FIM MODAL DESPESA -->
</section>
@endsection
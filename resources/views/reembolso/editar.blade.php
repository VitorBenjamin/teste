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
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Session::get('flash_message')['msg'] }}

				</div>								
				@endif

			</div>
		</div>
	</div>

	<!-- INCIO CABEÇALHO PADRAO -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#modalTranslado" class="btn bg-light-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>TRANSLADO</span>
						</a>
						<a data-toggle="modal" data-target="#modalDespesa" class="btn bg-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<span>DESPESA</span>
						</a>
						<a href="{{ route('solicitacao.andamento',$solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
							<i class="material-icons">send</i>
							<span>ENVIAR</span>
						</a>
					</div>
				</div>
				<form action="{{ route('reembolso.atualizarCabecalho',$solicitacao->id)}}" method="POST">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					@include('layouts._includes.cabecalho._cabecalho-editar')
				</form>
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
										<div class="icon-button-demo" >
											<a href="{{ route('reembolso.editarTranslado', $translado->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float"><i class="material-icons">settings</i></a>

											<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('reembolso.deletarTranslado', $translado->id)}}"><i class="material-icons">delete_sweep</i></a>
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
								@foreach ($solicitacao->despesa as $despesa)
								<tr>
									<td></td>
									<td>{{date('d/m/y',strtotime($despesa->data_despesa))}}</td>
									<td>{{$despesa->descricao}}</td>
									<td>{{$despesa->tipo_comprovante}}</td>
									<td>{{$despesa->valor}}</td>
									<td>
										<div class="icon-button-demo" >
											<a href="{{ route('reembolso.editarDespesa', $despesa->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float"><i class="material-icons">settings</i></a>

											<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('reembolso.deletarDespesa', $despesa->id)}}"><i class="material-icons">delete_sweep</i></a>
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
												<div class="col-md-2">
													<div class="form-group">
														<div class="form-line">
															<label for="data_translado">Data</label>
															<input type="text" name="data_translado" class="datepicker form-control" placeholder="Escolha uma Data"/>
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<label for="turno">Turno</label>
													<select id="turno" name="turno" class="form-control show-tick">
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
																<legend style="margin: 0px">Ida / Volta</legend>
															</fieldset>
															<input name="ida_volta" value="1" type="radio" id="ida_volta_sim" />
															<label style="margin: 15px 0px" for="ida_volta_sim">Sim</label>
															<input name="ida_volta" value="0" type="radio" id="ida_volta_nao" checked/>
															<label style="margin: 15px 0px" for="ida_volta_nao">Não</label>
														</div>
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<div class="form-line">
															<label for="distancia">Distância</label>
															<input type="text" name="distancia" class="form-control" placeholder="KM"/>
														</div>
													</div>
												</div>
												<div class="col-md-12">
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
					<form action="{{ route('reembolso.addDespesa',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
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
													<div class="form-group">
														<div class="form-line">
															<label for="valor">Valor</label>
															<input type="text" id="valor" name="valor" class="form-control" placeholder="R$." required/>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<div class="form-line">
															<label for="anexo_comprovante">Evie um Arquivo</label>
															<input type="file" name="anexo_comprovante" id="anexo_comprovante" required/>
															<button type="reset" id="pseudoCancel">
																Cancel
															</button>
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

</section>
@endsection
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
						<a data-toggle="modal" data-target="#modalCompra" class="btn bg-light-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>PRODUTO</span>
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
	
	<!-- SESSÂO COMENTÁRIO -->
	@if(count($solicitacao->comentarios) > 0)
	@include('layouts._includes._comentario')
	@endif
	<!-- FIM SESSÂO COMENTÁRIO  -->
	
	<!-- MODAL CADASTRO DO PRODUTO -->
	<div class="modal fade" id="modalCompra" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione um Produto</h4>
				</div>
				<div class="modal-body">
					<form action="{{ route('compra.addCompra',$solicitacao->id)}}" method="POST">
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
															<label for="data_compra">Data</label>
															<input type="text" value="" name="data_compra" class="datepicker form-control" placeholder="Escolha uma Data"/>
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
													<div class="form-group">
														<div class="form-line">
															<label for="quantidade">Quantidade</label>
															<input type="text" value="" name="quantidade" class="form-control" placeholder="Qtd."/>
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
									<span>ADD PRODUTO</span>
								</button>
							</div>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- FIM MODAL CADASTRO DA PRODUTO -->

	<!-- LISTAGEM DOS PRODUTOS  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DOS PRODUTOS
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped table-hover dataTable js-basic-example ">
						<thead>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Descrição</th>
								<th>Quantidade</th>
								<th>Ações</th>																	
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Descrição</th>
								<th>Quantidade</th>
								<th>Ações</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($solicitacao->compra as $compra)
							<tr>
								<td></td>
								<td>{{date('d/m/y',strtotime($compra->data_compra))}}</td>
								<td>{{$compra->descricao}}</td>
								<td>{{$compra->quantidade}}</td>									
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#modal{{$compra->id}}" role="button"><i class="material-icons">settings</i></a>

										<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('compra.deletarCompra', $compra->id)}}"><i class="material-icons">delete_sweep</i></a>
									</div>
								</td>
							</tr>
							<!-- MODAL TRANSLADO -->
							<div class="modal fade" id="modal{{$compra->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Editar um Produto</h4>
										</div>

										<!-- INCIO SESSÃO TRANSLADO -->
										<form action="{{ route('compra.atualizarCompra',$compra->id)}}" method="POST">
											{{ csrf_field() }}
											{{ method_field('PUT') }}
											<div class="modal-body">				

												<div class="row clearfix">
													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="data_compra">Data</label>
																<input type="text" value="{{$compra->data_compra}}" name="data_compra" class="datepicker form-control" placeholder="Escolha uma Data"/>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<div class="form-line">
																<label for="descricao">Descrição</label>
																<input type="text" value="{{$compra->descricao}}" name="descricao" class="form-control" placeholder="Descrição do produto"/>										
															</div>
														</div>
													</div>

													<div class="col-md-2">
														<div class="form-group">
															<div class="form-line">
																<label for="quantidade">Quantidade</label>
																<input type="text" value="{{$compra->quantidade}}" name="quantidade" class="form-control" placeholder="Qtd."/>
															</div>
														</div>								
													</div>
													<div class="col-md-2" style="margin-top: 20px">
														<button class="btn btn-primary btn-lg waves-effect">
															<i class="material-icons">save</i>
															<span>ATUALIZAR</span> 
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
	<!-- FIM LISTAGEM DOS PRODUTOS -->

	<!-- LISTAGEM DAS COTAÇÕES  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DAS COTAÇÕES
					</h2>
				</div>
				<div class="body">
					@foreach ($solicitacao->compra as $compra)
					<table class="table table-bordered table-striped table-hover dataTable">
						<thead>
							<tr>
								<th>Data Desejada</th>
								<th>Descrição</th>
								<th>Quantidade</th>
							</tr>
						</thead>
						<tbody>							
							<tr>
								<td>{{date('d/m/Y',strtotime($compra->data_compra))}}</td>
								<td>{{$compra->descricao}}</td>
								<td>{{$compra->quantidade}}</td>								
							</tr>												
						</tbody>
					</table>
					<h2><i class="material-icons">arrow_downward</i><span class="badge bg-cyan" style="padding: 8px 7px; font-size: 15px">COTAÇÕES</span><i class="material-icons">arrow_upward</i></h2>
					<div class="row clearfix">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">				
							<table class="table table-bordered table-striped table-hover dataTable">
								<thead>
									<tr>
										<th>Data</th>
										<th>Descrição</th>
										<th>Fornecedor</th>
										<th>Quantidade</th>
										<th>Valor</th>
										<th>Imagem</th>
										<th>Ações</th>
									</tr>
								</thead>
								<tbody>
									@include('compra.cotacao-2')											
								</tbody>
							</table>
						</div>
					</div>
					@endforeach						
				</div>
			</div>
		</div> 												
	</div>
	<!-- FIM LISTAGEM DAS COTAÇÕES -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<div class="row">
						<div class="col-sm-3">
							<h2 style="margin: 10px 0 0 0;"> <span style="vertical-align: -webkit-baseline-middle;
							">CADASTRAR COTAÇÕES</span></h2>
						</div>
						<div class="col-sm-offset-2 col-sm-4">
							<select id="selecionar_compra" name="compra_id" class="selectpicker form-control show-tick" data-size="5" data-live-search="true">
								<option value="">SELECIONE UMA COMPRA</option>
								@foreach ($solicitacao->compra as $compra)
								<option value="{{ $compra->id }}">{{ $compra->descricao }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-sm-offset-1 col-sm-1">
							<a name="add" id="add" class="btn bg-green waves-effect">
								<i class="material-icons">add</i>
								<span>ADD MAIS</span> 
							</a>
						</div>
					</div>
				</div>
				<form action="{{ route('compra.addCotacao',$solicitacao-> id)}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="compras_id" id="compras_id" value="" required>
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="body">
						<div id="dynamic_field">
							<div class="row clearfix">
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_cotacao">Data</label>
											<input id="data_cotacao" type="text" value="" name="data_cotacao[]" class="datepicker form-control" placeholder="Escolha uma Data" required />
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<div class="form-line">
											<label for="descricao">Descrição</label>
											<input id="descricao" type="text" value="" name="descricao[]" class="form-control" placeholder="Descrição do produto" required />										
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<div class="form-line">
											<label for="fornecedor">Fornecedor</label>
											<input id="fornecedor" type="text" value="" name="fornecedor[]" class="form-control" placeholder="Descrição do produto" required />										
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<div class="form-line">
											<label for="quantidade">Qtd.</label>
											<input type="text" value="" name="quantidade[]" class="form-control" placeholder="Qtd." required />
										</div>
									</div>								
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<div class="form-line">
											<label for="quantidade">Valor R$</label>
											<input type="numeric" name="valor[]" style="text-align:right" class="form-control" size="11"  value="" onKeyUp="moeda(this);" required>
										</div>
									</div>							
								</div>
							</div> 
						</div>
						<div class="row clearfix">
							<div class="col-md-12" style="margin-top: 20px">
								<button type="submit" id="cadastrar_cotacao" class="btn btn-block bg-green waves-effect">
									<i class="material-icons">send</i>
									<span>CADASTRAR COTAÇÕES</span> 
								</button>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div> 												
	</div>
</section>
@endsection
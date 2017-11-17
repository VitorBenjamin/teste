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
					<h2>Dados da Compra</h2>
				</div>
				<form action="{{ route('antecipacao.atualizarCabecalho',$solicitacao->id)}}" method="POST">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					@include('layouts._includes.cabecalho._cabecalho-editar')
				</form>
			</div>
		</div>
	</div>
	<!-- FIM CABEÇALHO PADRAO -->

	<!-- SESSÃO ANTECIPAÇÂO -->
	@if(empty($solicitacao->antecipacao[0]))
	<div class="row clearfix">
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
										<input type="text" value="" name="data_recebimento" class="datepicker form-control " placeholder="Escolha uma Data"/>
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
										<label for="valor_solicitado">Valor</label>
										<input type="text" value="" name="valor_solicitado" class="form-control" placeholder="R$."/>
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
	</div>
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
								<td>{{$antecipacao->valor_solicitado}}</td>									
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#modal{{$antecipacao->id}}" role="button"><i class="material-icons">settings</i></a>

										<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('antecipacao.deletarAntecipacao', $antecipacao->id)}}"><i class="material-icons">delete_sweep</i></a>
									</div>

								</td>
							</tr>


							<!-- MODAL TRANSLADO -->
							<div class="modal fade" id="modal{{$antecipacao->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Editar um Antecipação</h4>
										</div>

										<!-- INCIO SESSÃO TRANSLADO -->
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
							<!-- FIM MODAL TRANSLADO -->
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
@extends('layouts.app')
@section('content')

<section class="content">
	<div class="block-header">
		<h2>Dados da Solicitação {{$solicitacao->codigo}}</h2>			
	</div>
	
	<!-- INCIO CABEÇALHO PADRAO -->
	@include('layouts._includes.cabecalho._cabecalho_analise')
	<!-- FIM CABEÇALHO PADRAO -->

	<!-- MODAL COMENTÁRIO -->
	@include('layouts._includes._modalComentario')
	<!-- FIM MODAL COMENTÁRIO -->
	
	<!-- SESSÂO COMENTÁRIO -->
	@if(count($solicitacao->comentarios) > 0)
	@include('layouts._includes._comentario')
	@endif
	<!-- FIM SESSÂO COMENTÁRIO  -->

	<!-- SESSÂO COMPROVANTE -->
	@if(count($solicitacao->comprovante) == 0)
	@if($solicitacao->tipo == "COMPRA" || $solicitacao->tipo == "VIAGEM")
	@if($solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado_etapa2'))
	@include('layouts._includes.solicitacoes._addComprovante')
	@endif
	@else
	@include('layouts._includes.solicitacoes._addComprovante')
	@endif
	@else
	@include('layouts._includes.solicitacoes._comprovante')
	@endif 
	<!-- FIM SESSÂO COMPROVANTE  -->
	
	<!-- LISTAGEM DA VIAGEM  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTAGEM DA VIAGEM
					</h2>
				</div>
				
				<div class="body">
					@foreach ($solicitacao->viagem as $key => $viagem)
					<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
						<thead>
							<tr>
								<th></th>
								<th>Origem</th>
								<th>Data Ida</th>
								<th>Destino</th>
								<th>Data Volta</th>	
								<th>Passagem</th>
								<th>Hospedagem</th>
								<th>Bagagem</th>
								<th>Kg</th>
								<th>Locação</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td>{{$viagem->origem}}</td>
								<td>{{date('d/m/Y',strtotime($viagem->data_ida))}}</td>
								<td>{{$viagem->destino}}</td>
								<td>{{$viagem->data_volta == null ? 'Só Ida' : date('d/m/Y',strtotime($viagem->data_volta)) }}</td>
								<td>{{$viagem->passagem ? 'SIM' : 'NÃO'}}</td>
								<td>
									{{$viagem->hospedagem == 1 ? 'SIM' : 'NÃO'}}
								</td>
								<td>{{$viagem->bagagem == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$viagem->kg}}</td>
								<td>
									{{$viagem->locacao == 1 ? 'SIM' : 'NÃO'}}
								</td>
								<td class="acoesTD">
									@role('ADMINISTRATIVO')
									@if ($solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_administrativo') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_recorrente_financeiro'))
									<button type="button" class="btn btn-default waves-effect" data-toggle="modal" data-target="#addCotacao{{$viagem->id}}">COTAR</button>
									@elseif ($solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado'))
									<button type="button" class="btn btn-default waves-effect" data-toggle="modal" data-target="#addComprovante{{$viagem->id}}">COMPROVANTES</button>
									@else
									NENHUMA
									@endif
									@endrole
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
								<table class="table table-bordered table-striped table-hover dataTable table-simples">
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
											<td>{{$viagem->hospedagens ? date('d-m-Y', strtotime($viagem->data_cotacao)) : ''}}</td>
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

								<table class="table table-bordered table-striped table-hover dataTable table-simples">
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
								<table class="table table-bordered table-striped table-hover dataTable table-simples">
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
	<!-- FIM LISTAGEM DA VIAGEM  -->
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
							@foreach ($solicitacao->despesa as $key2 => $despesa)
							<tr>
								<td></td>
								<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
								<td>{{$despesa->descricao}}</td>
								<td>{{$despesa->tipo_comprovante}}</td>
								<td>R$ {{$despesa->valor}}</td>
								<td class="acoesTD">
									<div class="icon-button-demo" >
										@if($solicitacao->status[0]->descricao == "ABERTO-ETAPA2" || $solicitacao->status[0]->descricao == "DEVOLVIDO-ETAPA2")
										<a href="{{ route('viagem.editarDespesa', $despesa->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">settings</i>
										</a>

										<a style="margin: 0px 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{route('viagem.deletarDespesa',$despesa->id)}}">
											<i class="material-icons">delete_sweep</i>
										</a>
										@endif
										<div class="zoom-gallery">
											@if($despesa->anexo_pdf)
											<span>
												<a id="broken-image" class="mfp-image" target="_blank" href="{{URL::to('storage/despesas/'.$despesa->anexo_pdf)}}"><i class="material-icons">picture_as_pdf</i></a>
											</span>
											@else
											<a href="{{$despesa->anexo_comprovante}}" data-source="{{$despesa->anexo_comprovante}}" title="COMPROVANTE - {{$despesa->tipo_comprovante}} - {{date('d/m/Y',strtotime($despesa->data_despesa))}}" style="width:32px;height:32px;">
												<img class="img_popup" src="{{$despesa->anexo_comprovante}}" width="32" height="32">
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
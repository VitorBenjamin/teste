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
	@role('FINANCEIRO')
	@if ($solicitacao->status[0]->descricao == "APROVADO-ETAPA2")
	@include('layouts._includes.solicitacoes._addComprovante')
	@endif
	@endrole
	@else
	@include('layouts._includes.solicitacoes._comprovante')
	@endif 
	<!-- FIM SESSÂO COMPROVANTE  -->
	
	<!-- LISTAGEM DA ANTECIPAÇÃO  -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTA DE ANTECIPAÇÂO
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped table-hover dataTable">
						<thead>
							<tr>
								<th>Data</th>
								<th>Descrição</th>
								<th>Valor</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($solicitacao->antecipacao as $key => $antecipacao)
							<tr>
								<td>{{date('d/m/Y',strtotime($antecipacao->data_recebimento))}}</td>
								<td>{{$antecipacao->descricao}}</td>
								<td>R$ {{$antecipacao->valor}}</td>
								<td class="acoesTD">

									@role('FINANCEIRO')
									@if ($solicitacao->status[0]->descricao == "APROVADO")
									<button type="button" class="btn btn-default waves-effect m-r-20" style="float: left" data-toggle="modal" data-target="#addComprovante{{$antecipacao->id}}">ANEXAR</button>
									@endif
									@endrole
									<div class="zoom-gallery">
										@if($antecipacao->anexo_comprovante)
										<a href="{{$antecipacao->anexo_comprovante}}" data-source="{{$antecipacao->anexo_comprovante}}" title="{{$antecipacao->descricao}} - {{date('d/m/Y',strtotime($antecipacao->data_recebimento))}}" style="width:25px;height:25px;">
											<img style="border: 1px solid #9c9b9b; border-radius: 30px; margin-bottom: 0px" src="{{$antecipacao->anexo_comprovante}}" width="25" height="25">
										</a>
										@endif
									</div>
								</td>									
							</tr>
							<div class="modal fade" id="addComprovante{{$antecipacao->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="defaultModalLabel">COMPROVANTE DA ANTECIPAÇÃO</h4>
										</div>
										<div class="modal-body">
											<form action="{{ route('antecipacao.addComprovante',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
												{{ csrf_field() }}
												{{ method_field('PUT') }}
												<input type="hidden" name="antecipacao_id" value="{{$antecipacao->id}}">
												<div class="col-md-12">
													<div class="col-md-8">
														<div class="form-group">
															<div class="form-line">
																<label style="margin-bottom: 20px" for="anexo_comprovante">Comprovante da Antecipação (jpeg,bmp,png)</label>
																<input type="file" name="anexo_comprovante" id="anexo_comprovante" accept=".jpg,.png" required/>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<div class="form-group">
														<button class="btn btn-info">
															<i class="material-icons">save</i>
															<span>ANEXAR COMPROVANTE</span>
														</button>
													</div>
													<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
												</div>
											</form>
										</div>

									</div>
								</div>
							</div>
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
					<table class="table table-bordered table-striped table-hover js-basic-example">
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
							@foreach ($solicitacao->despesa as $key2 => $despesa)
							<tr>
								
								<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
								<td>{{$despesa->descricao}}</td>
								<td>{{$despesa->tipo_comprovante}}</td>
								<td>R$ {{$despesa->valor}}</td>
								<td class="acoesTD">
									<div class="icon-button-demo">

										@if(($solicitacao->status[0]->descricao == "ABERTO-ETAPA2" || $solicitacao->status[0]->descricao == "DEVOLVIDO-ETAPA2") && auth()->user()->id == $solicitacao->users_id))
										<a href="{{ route('antecipacao.editarDespesa', $despesa->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">settings</i>
										</a>
										<a style="margin: 0px 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{route('antecipacao.deletarDespesa',$despesa->id)}}">
											<i class="material-icons">delete_sweep</i>
										</a>
										@endif
										<div class="zoom-gallery" style="display: inline;">
											@if($despesa->anexo_comprovante)
											<a href="{{$despesa->anexo_comprovante}}" data-source="{{$despesa->anexo_comprovante}}" title="{{$despesa->tipo_comprovante}} - {{date('d/m/Y',strtotime($despesa->data_despesa))}}" style="width:32px;height:32px;">
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
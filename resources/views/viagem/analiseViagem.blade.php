@extends('layouts.app')
@section('content')

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
					<table class="table table-bordered table-striped nowrap table-hover dataTable table-simples">
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
						<tbody>
							@foreach ($solicitacao->viagem as $key => $viagem)
							<tr>
								<td></td>
								<td>{{$viagem->origem}}</td>
								<td>{{date('d/m/Y H:i',strtotime($viagem->data_ida))}}</td>
								<td>{{$viagem->destino}}</td>
								<td>{{date('d/m/Y H:i',strtotime($viagem->data_volta))}}</td>
								<td>
									{{$viagem->hospedagem == 1 ? 'SIM' : 'NÃO'}}
									@if($viagem->hospedagens)
									<div class="zoom-gallery">
										@if($viagem->hospedagens->anexo_pdf)
										<span>
											<a id="broken-image" class="mfp-image" target="_blank" href="{{URL::to('storage/hospedagem/'.$viagem->hospedagens->anexo_pdf)}}"><i class="material-icons">picture_as_pdf</i></a>
										</span>
										@else
										<a href="{{$viagem->hospedagens->anexo_comprovante}}" data-source="{{$viagem->hospedagens->anexo_comprovante}}" title="COMPROVANTE - {{$viagem->hospedagens->tipo_comprovante}} - {{date('d/m/Y',strtotime($viagem->hospedagens->data_compra))}}" style="width:32px;height:32px;">
											<img class="img_popup" src="{{$viagem->hospedagens->anexo_comprovante}}" width="32" height="32">
										</a>
										@endif
									</div>
									@endif
								</td>
								<td>{{$viagem->bagagem == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$viagem->kg}}</td>
								<td>
									{{$viagem->locacao == 1 ? 'SIM' : 'NÃO'}}
									@if($viagem->locacoes)
									<div class="zoom-gallery">
										@if($viagem->locacoes->anexo_pdf)
										<span>
											<a id="broken-image" class="mfp-image" target="_blank" href="{{URL::to('storage/hospedagem/'.$$viagem->locacoes->anexo_pdf)}}"><i class="material-icons">picture_as_pdf</i></a>
										</span>
										@else
										<a href="{{$viagem->locacoes->anexo_comprovante}}" data-source="{{$viagem->locacoes->anexo_comprovante}}" title="COMPROVANTE - {{$viagem->locacoes->tipo_comprovante}} - {{date('d/m/Y',strtotime($viagem->locacoes->data_compra))}}" style="width:32px;height:32px;">
											<img class="img_popup" src="{{$viagem->locacoes->anexo_comprovante}}" width="32" height="32">
										</a>
										@endif
									</div>
									@endif
								</td>

								<td class="acoesTD">
									@role('ADMINISTRATIVO')
									<button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#addComprovante{{$viagem->id}}">ANEXAR</button>
									@endrole
									@if($viagem->anexo_pdf || $viagem->anexo_comprovante)
									<div class="zoom-gallery">
										@if($viagem->anexo_pdf)
										<span>
											<a id="broken-image" class="mfp-image" target="_blank" href="{{URL::to('storage/viagem/'.$viagem->anexo_pdf)}}"><i class="material-icons">picture_as_pdf</i></a>
										</span>
										@else
										<a href="{{$viagem->anexo_comprovante}}" data-source="{{$viagem->anexo_comprovante}}" title="COMPROVANTE - {{$viagem->tipo_comprovante}} - {{date('d/m/Y',strtotime($viagem->data_compra))}}" style="width:32px;height:32px;">
											<img class="img_popup" src="{{$viagem->anexo_comprovante}}" width="32" height="32">
										</a>
										@endif
									</div>
									@endif
								</td>	
							</tr>
							<div class="modal fade" id="addComprovante{{$viagem->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="defaultModalLabel">COMPROVANTES DA VIAGEM</h4>
										</div>
										<div class="modal-body">
											<form action="{{ route('viagem.addComprovante',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
												{{ csrf_field() }}
												{{ method_field('PUT') }}
												<input type="hidden" name="viagem_id" value="{{$viagem->id}}">
												<div class="col-md-12">
													<div class="row clearfix">
														<div class="col-md-2">
															<div class="form-group">
																<div class="form-line">
																	<label for="data_compra">Data</label>
																	<input type="text" id="data_compra" value="{{old('data_compra')}}"name="data_compra" class="datepicker form-control" placeholder="Clique"/>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<div class="form-line">
																	<label for="observacao_comprovante">Observação</label>
																	<input type="text" value="{{old('observacao_comprovante')}}" name="observacao_comprovante" class="form-control" placeholder="Observação"/>										
																</div>
															</div>
														</div>											
														<div class="col-md-2">
															<b>Custo da Passagem</b>
															<div class="input-group">
																<span class="input-group-addon">
																	R$
																</span>
																<div class="form-line">
																	<input type="numeric" value="{{old('custo_passagem')}}" name="custo_passagem" class="form-control valor" required/>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<div class="form-line">
																	<label style="margin-bottom: 20px" for="anexo_passagem">Anexar Passagem</label>
																	<input type="file" name="anexo_passagem" id="anexo_passagem" required/>											
																</div>
															</div>
														</div>
													</div>
													@if($viagem->hospedagem == 1)
													<div class="row clearfix">
														<div class="col-md-2">
															<div class="form-group">
																<div class="form-line">
																	<label for="data_hospedagem">Data Hospedagem</label>
																	<input type="text" id="data_hospedagem" value="{{old('data_hospedagem')}}" name="data_hospedagem" class="datepicker form-control" placeholder="Clique"/>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<div class="form-line">
																	<label for="observacao_hospedagem">Observação Hospedagem</label>
																	<input type="text" value="{{old('observacao_hospedagem')}}" name="observacao_hospedagem" class="form-control" placeholder="Observação"/>										
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<b>Custo da Hospedagem</b>
															<div class="input-group">
																<span class="input-group-addon">
																	R$
																</span>
																<div class="form-line">
																	<input type="numeric" value="{{old('custo_hospedagem')}}" name="custo_hospedagem" class="form-control valor" required/>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<div class="form-line">
																	<label style="margin-bottom: 20px" for="anexo_hospedagem">Anexar Hospedagem</label>
																	<input type="file" name="anexo_hospedagem" id="anexo_hospedagem" required/>														
																</div>
															</div>
														</div>
													</div>
													@endif

													@if($viagem->locacao == 1)
													<div class="row clearfix">
														<div class="col-md-2">
															<div class="form-group">
																<div class="form-line">
																	<label for="data_locacao">Data Locação</label>
																	<input type="text" id="data_locacao" value="{{old('data_locacao')}}"name="data_locacao" class="datepicker form-control" placeholder="Clique"/>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<div class="form-line">
																	<label for="observacao_locacao">Observação Locação</label>
																	<input type="text" value="{{old('observacao_locacao')}}" name="observacao_locacao" class="form-control" placeholder="Observação"/>										
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<b>Custo da Locação</b>
															<div class="input-group">
																<span class="input-group-addon">
																	R$
																</span>
																<div class="form-line">
																	<input type="numeric" value="{{old('custo_locacao')}}" name="custo_locacao" class="form-control valor" required/>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<div class="form-line">
																	<label style="margin-bottom: 20px" for="anexo_locacao">Anexar Locação</label>
																	<input type="file" name="anexo_locacao" id="anexo_locacao" required/>														
																</div>
															</div>
														</div>
													</div>
													@endif
												</div>
												<div class="modal-footer">
													<div class="form-group">
														<button class="btn btn-info">
															<i class="material-icons">save</i>
															<span>ANEXAR COMPROVANTES</span>
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
							@endforeach														
						</tbody>
					</table>
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
							@foreach ($solicitacao->despesa as $key2 => $despesa)
							<tr>
								<td></td>
								<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
								<td>{{$despesa->descricao}}</td>
								<td>{{$despesa->tipo_comprovante}}</td>
								<td>{{$despesa->valor}}</td>
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
	<!-- FIM MODAL GALERIA -->
</section>
@endsection
<!-- @push('scripts2')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.3/js/ajax-bootstrap-select.min.js') !!}
@endpush
@push('scripts')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/locale/pt-br.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap.min.js') !!}
{!! Html::script('https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js')!!}
@endpush -->
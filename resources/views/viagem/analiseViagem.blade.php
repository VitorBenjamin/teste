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
	<div class="modal fade" id="modalDevolver" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">DESEJA DEVOLVER ESSA SOLICITAÇÂO?</h4>
				</div>
				<!-- INCIO SESSÃO DESPESA -->
				<div class="modal-body">
					<form action="{{ route('solicitacao.devolver',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="body">
							<div class="row clearfix">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="card">
										<div class="header">
											<h2>
												Deixe uma Observação 
											</h2>
										</div>
										<div class="body">
											<div class="row clearfix">
												<div class="col-md-12">
													<div class="form-group">
														<div class="form-line">
															<label for="comentario">Observação</label>
															<textarea name="comentario" class="form-control" placeholder="..." required></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<div class="form-group">
												<button class="btn btn-info">
													<i class="material-icons">replay</i>
													<span>DEVOLVER</span>
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
	<!-- FIM MODAL COMENTÁRIO -->
	
	<!-- LISTAGEM DA VIAGEM  -->
	@include('layouts._includes._comentario')
	<!-- FIM LISTAGEM DA VIAGEM  -->
	
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
					<table class="table table-bordered table-striped nowrap table-hover dataTable js-basic-example ">
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
								<td>{{date('d-m-y H:m',strtotime($viagem->data_ida))}}</td>
								<td>{{$viagem->destino}}</td>
								<td>{{date('d-m-y H:m',strtotime($viagem->data_volta))}}</td>
								<td>{{$viagem->hospedagem == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$viagem->bagagem == 1 ? 'SIM' : 'NÃO'}}</td>
								<td>{{$viagem->kg}}</td>
								<td>{{$viagem->locacao == 1 ? 'SIM' : 'NÃO'}}</td>

								<td class="acoesTD">
									@role('FINANCEIRO')
									<button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#addComprovante{{$viagem->id}}">ANEXAR</button>
									@endrole
									@if($viagem->viagens_comprovantes_id == null)
									<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" disabled>
										<i class="material-icons">photo_library</i>
									</a>
									@else
									<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" onclick="openModal();currentSlide({{$key+$viagem->id+2}})">
										<i class="material-icons">photo_library</i>
									</a>
									@endif
								</td>	
							</tr>
							<div class="modal fade" id="addComprovante{{$viagem->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
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
														<div class="col-md-4">
															<div class="form-group">
																<div class="form-line">
																	<label for="data_compra">Data</label>
																	<input type="text" id="data_compra" value="{{old('data_compra')}}"name="data_compra" class="datepicker form-control" placeholder="Clique"/>
																</div>
															</div>
														</div>
														<div class="col-md-8">
															<div class="form-group">
																<div class="form-line">
																	<label for="observacao">Observação</label>
																	<input type="text" value="{{old('observacao')}}" name="observacao" class="form-control" placeholder="Observação"/>										
																</div>
															</div>
														</div>
													</div>
													<div class="row clearfix">														
														<div class="col-md-4">
															<b>Cursto da Passagem</b>
															<div class="input-group">
																<span class="input-group-addon">
																	R$
																</span>
																<div class="form-line">
																	<input type="numeric" value="{{old('custo_passagem')}}" name="custo_passagem" class="form-control valor" required/>
																</div>
															</div>
														</div>
														<div class="col-md-8">
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
														<div class="col-md-4">
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
														<div class="col-md-8">
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
														<div class="col-md-4">
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
														<div class="col-md-8">
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
															<span>ANEXAR COMPROVANTE</span>
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
								<td>{{date('d-m-y',strtotime($despesa->data_despesa))}}</td>
								<td>{{$despesa->descricao}}</td>
								<td>{{$despesa->tipo_comprovante}}</td>
								<td>{{$despesa->valor}}</td>
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a href="{{ route('viagem.editarDespesa', $despesa->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">settings</i>
										</a>

										<a style="margin: 0px 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{route('viagem.deletarDespesa',$despesa->id)}}">
											<i class="material-icons">delete_sweep</i>
										</a>
										<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" onclick="openModal();currentSlide({{$key2}})">
											<i class="material-icons">photo_library</i>
										</a>
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
	
	<!-- MODAL GALERIA -->
	<div id="myModal" class="modal-2">
		<span class="close-2 cursor" onclick="closeModal()">&times;</span>
		<div class="modal-content-2">

			@foreach ($solicitacao->viagem as $key => $viagem)
			@if($viagem->viagens_comprovantes_id != null)
			
			@if($viagem->comprovante->anexo_passagem != null)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label bg-teal">{{$viagem->origem}}</span> x <span class="label bg-green">{{$viagem->destino }} </span> <span class="label label-danger"> Passagem</span></h3></div>
				<img src="{{$viagem->comprovante->anexo_passagem}}" style="width:100%; max-height: 70%">
			</div>
			@endif

			@if($viagem->comprovante->anexo_hospedagem != null)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label bg-teal">{{$viagem->origem}}</span> x <span class="label bg-green">{{$viagem->destino }} </span> 
					<span class="label label-warning"> Hospedagem</span> </h3>
				</div>
				<img src="{{$viagem->comprovante->anexo_hospedagem}}" style="width:100%; max-height: 70%">
			</div>
			@endif

			@if($viagem->comprovante->anexo_locacao != null)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label label-info">{{$viagem->origem}} x {{$viagem->destino}} Locação</span></h3></div>
				<img src="{{$viagem->comprovante->anexo_locacao}}" style="width:100%; max-height: 70%">
			</div>
			@endif

			@endif	
			@endforeach		
			
			@foreach ($solicitacao->despesa as $despesa)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label bg-teal">{{$despesa->tipo_comprovante}}</span><span class="label label-danger"> {{date('d/m/y',strtotime($despesa->data_despesa))}}</span></h3></div>
				<img src="{{$despesa->anexo_comprovante}}" style="width:100%; max-height: 70%">
			</div>
			@endforeach											

			<a class="prev-2" onclick="plusSlides(-1)">&#10094;</a>
			<a class="next-2" onclick="plusSlides(1)">&#10095;</a>

			<!-- <div class="caption-container">
				<p id="caption"></p>
			</div> -->
			
			<!-- @foreach ($solicitacao->despesa as $key => $despesa)
			<div class="column">
				<img class="demo cursor" src="{{$despesa->anexo_comprovante}}" style="width:100%" onclick="currentSlide({{$key}})" alt="{{$despesa->descricao}}">
			</div>

			@endforeach -->

		</div>
	</div>
	<!-- FIM MODAL GALERIA -->

	<!-- FIM MODAL GALERIA -->
</section>
@endsection
@extends('layouts.app')
@section('content')

<section class="content">
	<div class="block-header">
		<h2>Dados da Solicitação</h2>			
	</div>
	
	<!-- INCIO CABEÇALHO PADRAO -->
	@include('layouts._includes.cabecalho._cabecalho_analise')
	<!-- FIM CABEÇALHO PADRAO -->


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
								<td>{{date('d/m/y',strtotime($viagem->data_ida))}}</td>
								<td>{{$viagem->destino}}</td>
								<td>{{date('d/m/y',strtotime($viagem->data_volta))}}</td>
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
											<h4 class="modal-title" id="defaultModalLabel">COMPROVANTE DE ENTREGA DA ANTECIPAÇÂO</h4>
										</div>
										<div class="modal-body">
											<form action="{{ route('viagem.addComprovante',$viagem->id)}}" method="POST" enctype="multipart/form-data">
												{{ csrf_field() }}
												{{ method_field('PUT') }}
												<input type="hidden" name="solicitacao_id" value="{{$solicitacao->id}}">
												<div class="col-md-12">
													<div class="row clearfix">
														<div class="col-md-4">
															<div class="form-group">
																<div class="form-line">
																	<label for="data_compra">Data</label>
																	<input type="text" id="data_compra" name="data_compra" class="datepicker form-control" placeholder="Clique"/>
																</div>
															</div>
														</div>
														<div class="col-md-8">
															<div class="form-group">
																<div class="form-line">
																	<label for="observacao">Observação</label>
																	<input type="text" value="" name="observacao" class="form-control" placeholder="Observação"/>										
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
																	<input type="numeric" name="custo_passagem" class="form-control valor" required/>
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
																	<input type="numeric" name="custo_hospedagem" class="form-control valor" required/>
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
																	<input type="numeric" name="custo_locacao" class="form-control valor" required/>
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

	<!-- MODAL GALERIA -->
	<div id="myModal" class="modal-2">
		<span class="close-2 cursor" onclick="closeModal()">&times;</span>
		<div class="modal-content-2">

			@foreach ($solicitacao->viagem as $key => $viagem)
			@if($viagem->viagens_comprovantes_id != null)
			@foreach ($viagem->comprovante as $comp)
			
			@if($comp->anexo_passagem != null)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label bg-teal">{{$viagem->origem}}</span> x <span class="label bg-green">{{$viagem->destino }} </span> <span class="label label-danger"> Passagem</span></h3></div>
				<img src="{{$comp->anexo_passagem}}" style="width:100%; max-height: 70%">
			</div>
			@endif

			@if($comp->anexo_hospedagem != null)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label bg-teal">{{$viagem->origem}}</span> x <span class="label bg-green">{{$viagem->destino }} </span> 
					<span class="label label-warning"> Hospedagem</span> </h3>
				</div>
				<img src="{{$comp->anexo_hospedagem}}" style="width:100%; max-height: 70%">
			</div>
			@endif

			@if($comp->anexo_locacao != null)
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label label-info">{{$viagem->origem}} x {{$viagem->destino}} Locação</span></h3></div>
				<img src="{{$comp->anexo_locacao}}" style="width:100%; max-height: 70%">
			</div>
			@endif

			@endforeach
			@endif	
			@endforeach													

			<a class="prev-2" onclick="plusSlides(-1)">&#10094;</a>
			<a class="next-2" onclick="plusSlides(1)">&#10095;</a>

			<!-- <div class="caption-container">
				<p id="caption"></p>
			</div> -->
			
			{{-- @foreach ($solicitacao->despesa as $key => $despesa)
			<div class="column">
				<img class="demo cursor" src="{{$despesa->anexo_comprovante}}" style="width:100%" onclick="currentSlide({{$key}})" alt="{{$despesa->descricao}}">
			</div>

			@endforeach --}}
			
		</div>
	</div>

	<!-- FIM MODAL GALERIA -->
</section>
@endsection
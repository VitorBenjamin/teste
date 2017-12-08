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
	

	@if($solicitacao->status[0]->descricao =="ABERTO" || $solicitacao->status[0]->descricao =="DEVOLVIDO" || $solicitacao->status[0]->descricao =="COORDENADOR-ABERTO") 
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
					<!-- <h2>Cabecalho da antecipacao</h2> -->
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a data-toggle="modal" data-target="#modalDespesa" class="btn bg-light-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>ADICIONAR DESPESA</span>
						</a>
						@if($solicitacao->despesa->count() == 0)
						<a href="{{ route('solicitacao.finalizar', $solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
							<i class="material-icons">done_all</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>FINALIZAR</span>
						</a>
						@else
						<a href="{{ route('solicitacao.andamento', $solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
							<i class="material-icons">send</i>
							<span>ENVIAR</span>
						</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div><!-- MODAL DESPESA -->
	
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
															<label for="anexo_comprovante">Envie um Arquivo (jpeg,bmp,png)</label>
															<input type="file" name="anexo_comprovante" id="anexo_comprovante" required/>
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

	<!-- INCIO CABEÇALHO PADRAO -->
	@include('layouts._includes.cabecalho._cabecalho_analise')
	<!-- FIM CABEÇALHO PADRAO -->
	@endif
	<!-- FIM CABEÇALHO PADRAO -->

	<!-- LISTAGEM DA antecipacao  -->
	@include('layouts._includes._comentario')
	<!-- FIM LISTAGEM DA antecipacao  -->

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
								<!-- <div class="col-md-2" style="margin-top: 20px">
									<button class="btn btn-primary waves-effect">
										<i class="material-icons">save</i>
										<span>ADD ANTECIPAÇÃO</span> 
									</button>
								</div> -->
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
	@endif
	<!-- SESSÃO ANTECIPAÇÂO -->
	@if(empty($solicitacao->antecipacao[0]))
	<!-- <div class="row clearfix">
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
										<input type="text" value="" name="data_recebimento" class="datepicker2 form-control " placeholder="Escolha uma Data"/>
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
								<b>Valor</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input type="numeric" name="valor" class="form-control valor" />
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
	</div> -->
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
							@foreach ($solicitacao->antecipacao as $key => $antecipacao)
							<tr>
								<td></td>
								<td>{{date('d/m/y',strtotime($antecipacao->data_recebimento))}}</td>
								<td>{{$antecipacao->descricao}}</td>
								<td>R$ {{$antecipacao->valor}}</td>									
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#modal{{$antecipacao->id}}" role="button"><i class="material-icons">settings</i></a>

										<a style="margin: 0px 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('antecipacao.deletarAntecipacao', $antecipacao->id)}}"><i class="material-icons">delete_sweep</i></a>
										@if($antecipacao->anexo_comprovante != null)
										<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" onclick="openModal();currentSlide({{$key}})">
											<i class="material-icons">photo_library</i>
										</a>
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

										<!-- INCIO SESSÃO ANTECIPAÇÂO -->
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
													<!-- <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button> -->
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
							@foreach ($solicitacao->despesa as $key => $despesa)
							<tr>
								<td></td>
								<td>{{date('d/m/y',strtotime($despesa->data_despesa))}}</td>
								<td>{{$despesa->descricao}}</td>
								<td>{{$despesa->tipo_comprovante}}</td>
								<td>{{$despesa->valor}}</td>
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a href="{{ route('antecipacao.editarDespesa', $despesa->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">settings</i>
										</a>

										<a style="margin: 0px 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{route('antecipacao.deletarDespesa',$despesa->id)}}">
											<i class="material-icons">delete_sweep</i>
										</a>
										<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" onclick="openModal();currentSlide({{$key+1}})">
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

			@foreach ($solicitacao->antecipacao as $key => $antecipacao)
			@if($antecipacao->anexo_comprovante != null)		
			<div class="mySlides">
				<div class="numbertext"><h3><span class="label bg-green">COMPROVANTE DE PAGAMENTO DA ANTECIPAÇÃO</span></h3></div>
				<img src="{{$antecipacao->anexo_comprovante}}" style="width:100%; max-height: 70%">
			</div>
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

</section>
@endsection
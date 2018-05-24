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
						<a data-toggle="modal" data-target="#modalGuia" class="btn bg-light-green waves-effect" role="button">
							<i class="material-icons">exposure_plus_1</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>GUIA</span>
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

	<!-- MODAL CADASTRO DA GUIA -->
	<div class="modal fade" id="modalGuia" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Adicione uma Guia</h4>
				</div>
				<!-- INCIO SESSÃO VIAGEM -->
				<div class="modal-body">
					<form action="{{ route('guia.addGuia',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('PUT') }}			
						<div class="body">
							<div class="row clearfix">

								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_limite">Data</label>
											<input type="text" value="" name="data_limite" class="datepicker form-control" placeholder="Escolha uma Data" required />
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="reclamante">Adverso</label>
											<input type="text" value="" name="reclamante" class="form-control" placeholder="Nome do Reclamante" required/>
										</div>
									</div>
								</div>

								<div class="col-md-2">
									<label for="perfil_pagamento">Perfil Pagamento</label>
									<select id="perfil_pagamento" name="perfil_pagamento" class="form-control show-tick" required>
										<option value="BOLETO">BOLETO</option>
										<option value="DEPOSITO">DEPÓSITO</option>
										<option value="DAJ">DAJ</option>										
										<option value="DAF">DAF</option>
										<option value="DMA">DAM</option>
										<option value="GRU">GRU</option>
										<option value="GFIP">GFIP</option>
									</select>
								</div>

								<div class="col-md-2">
									<label for="banco">Banco</label>
									<select id="banco" name="banco" class="form-control show-tick" required>
										<option value="BANCO DO BRASIL">BANCO DO BRASIL</option>										
										<option value="ITAU">ITAU</option>
										<option value="BRADESCO">BRADESCO</option>
										<option value="CAIXA">CAIXA</option>
										<option value="SICOB">SICOB</option>								
									</select>
								</div>
								<div class="col-md-2">
									<label for="tipo_guias_id">Tipo</label>
									<select id="tipo_guias_id" name="tipo_guias_id" class="form-control show-tick" data-live-search="true" data-size="5" required>
										@foreach($tipo_guia as $grupo => $tipo)
										<optgroup label="{{$grupo}}">
											@foreach($tipo as $desc)
											<option value="{{$desc->id}}">{{$desc->descricao}}</option>
											@endforeach	
										</optgroup>
										@endforeach						
									</select>
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
							</div>
							<div class="row clearfix">
								<div class="col-md-2">
									<div class="form-group">
										<fieldset>
											<legend style="margin: 0">Prioridade</legend>
										</fieldset>
										<input name="prioridade" value="1" type="radio" id="simP" />
										<label style="margin: 15px 15px 0px 0px" for="simP">Sim</label>
										<input name="prioridade" value="0" type="radio" id="naoP" checked />
										<label style="margin: 15px 15px 0px 0px" for="naoP">Não</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="form-line">
											<textarea rows="2" name="observacao" class="form-control no-resize" placeholder="Insira uma Observação" required></textarea>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<div class="form-line">
											<label for="anexo_guia">Anexar Guia (JPG)</label>
											<input style="margin-top: 10px " type="file" name="anexo_guia" id="anexo_guia" accept="image/jpeg,image/jpg" required/>
										</div>
									</div>								
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="form-group">
								<button class="btn btn-info">
									<i class="material-icons">save</i>
									<span>ADD GUIA</span>
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

	<!-- LISTAGEM DA VIAGEM  -->
	@if(count($solicitacao->comentarios)>0)
	@include('layouts._includes._comentario')
	@endif
	<!-- FIM LISTAGEM DA VIAGEM  -->

	<!-- LISTAGEM DA GUIA  -->
	@if (count($solicitacao->guia)>0)
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LISTA DA GUIA
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped table-hover dataTable table-simples-guia">
						<thead>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Prioridade</th>
								<th>Reclamante</th>
								<th>Perfil</th>
								<th>Banco</th>
								<th>Tipo</th>
								<th style="min-width:120px">Valor</th>
								<th>Observacao</th>
								<th>Guia</th>
								<th style="min-width:80px">Ações</th>																	
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Data</th>
								<th>Prioridade</th>
								<th>Reclamante</th>
								<th>Perfil</th>
								<th>Banco</th>
								<th>Tipo</th>
								<th style="min-width:120px">Valor</th>
								<th>Observacao</th>
								<th>Guia</th>
								<th style="min-width:80px">Ações</th>
							</tr>
						</tfoot>
						<tbody> 
							@foreach ($solicitacao->guia as $guia)
							<tr>
								<td></td>
								<td>{{date('d/m/y',strtotime($guia->data_limite))}}</td>
								<td>{{$guia->prioridade == 1 ? 'SIM' : 'NÃO' }}</td>
								<td>{{$guia->reclamante}}</td>									
								<td>{{$guia->perfil_pagamento}}</td>
								<td>{{$guia->banco}}</td>
								<td>{{$guia->tipoGuia()->first()->descricao}}</td>
								<td>R$ {{ $guia->valor }}</td>
								<td>{{$guia->observacao }} </td>
								<td>
									<div class="zoom-gallery">
										<a href="{{$guia->anexo_guia}}" data-source="{{$guia->anexo_guia}}" title="GUIA - {{date('d/m/Y',strtotime($guia->data_limite))}}" style="width:32px;height:32px;">
											<img class="img_popup" src="{{$guia->anexo_guia}}" width="32" height="32">
										</a>
									</div>
								</td>
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<a href="{{ route('guia.editarGuia', $guia->id)}}" class="btn btn-circle waves-effect waves-circle waves-float" ><i class="material-icons">settings</i></a>
										
										<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('guia.deletarGuia', $guia->id)}}"><i class="material-icons">delete_sweep</i></a>

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
	@endif
	<!-- FIM LISTAGEM DA ANTECIPAÇÃO -->
</section>
@endsection
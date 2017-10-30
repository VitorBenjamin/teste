@extends('layouts.app')

@section('content')

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Cadastro De Reembolso</h2>
		</div>
		<form action="{{ route('reembolso.salvar')}}" method="post" enctype="multipart/form-data">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								Cabeçalho Padrão								
							</h2>
					</div>
					<div class="body">
						<div class="row clearfix">
							{{ csrf_field() }}
							<div class="col-md-2">
								<label for="origem_despesa">Origem de Despesa</label>
								<select id="origem_despesa" name="origem_despesa" class="form-control show-tick">
									<option value="">Selecione</option>
									<option value="escritorio">Escritorio</option>
									<option value="cliente">Cliente</option>

								</select>
							</div>
							<div class="col-md-2">
								<label for="clientes_id">Cliente</label>
								<select id="clientes_id" name="clientes_id" class="form-control show-tick" data-live-search="true">
									<option value="">Selecione</option>
									@foreach ($clientes as $cliente)
									<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label for="solicitantes_id">Solicitante</label>
								<select id="solicitantes_id" name="solicitantes_id" class="form-control show-tick" data-live-search="true">
									<option value="">Selecione</option>
									@foreach ($solicitantes as $solicitante)
									<option value="{{ $solicitante->id }}">{{ $solicitante->nome }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<div class="form-line">
										<label for="processos_id">Número de Processo</label>
										<input type="text" id="processos_id" name="processos_id" class="form-control" placeholder="N°" />
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<label for="area_atuacoes_id">Área de Atendimento</label>
								<select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-live-search="true">
									<option value="">Selecione</option>
									@foreach ($areas as $area)
									<option value="{{ $area->id }}">{{ $area->tipo }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label for="contrato">Tipo de Contrato</label>
								<select id="contrato" name="contrato" class="form-control show-tick" data-live-search="true">
									<option value="">Selecione</option>
									<option value="consultivo">Consultivo</option>
									<option value="contecioso">Contecioso</option>
									<option value="preventivo">Preventivo</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- FIM CABEÇALHO PADRAO -->

		<!-- INCIO SESSÃO TRANSLADO -->
		<div class="body">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								Translado
							</h2>
						</div>
						<div class="body">
							<div class="row clearfix">
								<div class="col-sm-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_translado">Data</label>
											<input type="text" name="data_translado" class="datepicker form-control" placeholder="Escolha uma Data"/>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<label for="turno">Turno</label>
									<select id="turno" name="turno" class="form-control show-tick" data-live-search="true">
										<option value="">Selecione</option>
										<option value="Matutino">Matutino</option>
										<option value="Verpertino">Verpertino</option>
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
								<div class="col-md-1">
									<div class="form-group">
										<div>
											<fieldset>
												<legend>Ida Volta</legend>
											</fieldset>
											<input type="checkbox" class="form-control" style="margin: -15px 0 0" name="ida-volta" id="ida-volta" class="filled-in" value="true"/>
											<label for="ida-volta">Ida/Volta</label>										
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="distancia">Distância (KM)</label>
											<input type="text" name="distancia" class="form-control" placeholder=""/>
										</div>
									</div>								
								</div>
								<div class="col-sm-12">
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

		<!-- INCIO SESSÃO DEPESAS -->
		<div class="body">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								Despesas
							</h2>
						</div>
						<div class="body">
							<div class="row clearfix">
								<div class="col-sm-2">
									<div class="form-group">
										<div class="form-line">
											<label for="data_despesa">Data</label>
											<input type="text" name="data_despesa" class="datepicker form-control" placeholder="Escolha uma Data"/>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<label for="tipo_comprovante">Comprovante</label>
									<select id="tipo_comprovante" name="tipo_comprovante" class="form-control show-tick">
										<option value="">Selecione</option>
										<option value="Matutino">Hospedagem</option>
										<option value="Verpertino">Alimentação</option>
										<option value="Verpertino">Transporte</option>

									</select>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="form-line">
											<label for="descricao">Descrição</label>
											<input type="text" name="descricao" class="form-control" placeholder=""/>										
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<div class="form-line">
											<label for="valor">Valor</label>
											<input type="text" id="valor" name="valor" class="form-control" placeholder=""/>
										</div>
									</div>								
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="form-line">
											<label for="anexo_comprovante">Evie um Arquivo</label>
											<input type="file" name="anexo_comprovante" id="anexo_comprovante" />
											<button type="reset" id="pseudoCancel">
												Cancel
											</button>
										</div>
									</div>								
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<button class="btn btn-info">Cadastrar</button>
		</div>
	</form>
	<!-- #END# Select -->
</div>
</section>
@endsection
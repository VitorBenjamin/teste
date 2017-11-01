@extends('layouts.app')

@section('content')

<section class="content">
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
								<label for="origem_despesa">Origem da Despesa</label>
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
							<div class="col-sm-4">
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
						</div>
						<div class="row clearfix">
							<div class="col-md-2">
								<label for="contrato">Tipo de Contrato</label>
								<select id="contrato" name="contrato" class="form-control show-tick" data-live-search="true">
									<option value="">Selecione</option>
									<option value="consultivo">Consultivo</option>
									<option value="contecioso">Contecioso</option>
									<option value="preventivo">Preventivo</option>
								</select>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div>
										<fieldset>
											<legend>Urgência</legend>
										</fieldset>
										<input name="urgente" value="1" type="radio" id="sim"  />
										<label style="margin: 15px" for="sim">Sim</label>
										<input name="urgente" value="0" type="radio" id="nao" checked />
										<label style="margin: 15px" for="nao">Não</label>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-group ">
							<button class="btn btn-info">Cadastrar</button>
						</div>
						
					</div>

				</div>

			</div>

		</div>

		<!-- FIM CABEÇALHO PADRAO -->			
	</form>
	<!-- #END# Select -->

</section>
@endsection
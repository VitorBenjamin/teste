@extends('layouts.app')

@section('content')

<section class="content">
	<div class="block-header">
		<h2>Cadastro De Viagem</h2>
	</div>
	<form id="form_validation" action="{{ route('reembolso.salvar')}}" method="POST">
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
								<select id="origem_despesa" name="origem_despesa" class="form-control show-tick" >
									@if(old('origem_despesa'))
									<option value="{{ old('origem_despesa') }}">{{ old('origem_despesa') }}</option>
									@if(old('origem_despesa') == "ESCRITÓRIO")
									<option value="CLIENTE">CLIENTE</option>
									<option value="">SELECIONE</option>
									@else
									<option value="ESCRITÓRIO">ESCRITÓRIO</option>
									<option value="CLIENTE">CLIENTE</option>
									@endif										
									@else
									<option value="">SELECIONE</option>
									<option value="ESCRITÓRIO">ESCRITÓRIO</option>
									<option value="CLIENTE">CLIENTE</option>
									@endif									
								</select>
							</div>
							<div class="col-md-2">
								<label for="clientes_id">Cliente</label>
								<select id="clientes_id" name="clientes_id" class="form-control show-tick" data-live-search="true">
									<option value="">SELECIONE</option>
									@foreach ($clientes as $cliente)
									<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label for="solicitantes_id">Solicitante</label>
								<select id="solicitantes_id" name="solicitantes_id" class="form-control show-tick" data-live-search="true" required>
									<option value="">SELECIONE</option>
									@foreach ($solicitantes as $solicitante)
									<option value="{{ $solicitante->id }}">{{ $solicitante->nome }}</option>
									@endforeach
								</select>
							</div>
							<div class="demo-masked-input">
								<div class="col-sm-4">
									<b>Número de Processo</b>
									<div class="input-group">
										<div class="form-line">
											<input type="text" name="processo" class="form-control processo" placeholder="Ex: 9999999-99.9999.9.99.9999" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<label for="area_atuacoes_id">Área de Atendimento</label>
								<select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-live-search="true" required>
									<option value="">SELECIONE</option>
									@foreach ($areas as $area)
									<option value="{{ $area->id }}">{{ $area->tipo }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-md-2">
								<label for="contrato">Tipo de Contrato</label>
								<select id="contrato" name="contrato" class="form-control show-tick" data-live-search="true" >
									<option value="">SELECIONE</option>
									<option value="CONSULTIVO">CONSULTIVO</option>
									<option value="CONTECIOSO">CONTECIOSO</option>
									<option value="PREVENTIVO">PREVENTIVO</option>
								</select>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<fieldset>
										<legend>Urgência</legend>
									</fieldset>
									<input name="urgente" value="1" type="radio" id="sim" />
									<label style="margin: 15px" for="sim">Sim</label>
									<input name="urgente" value="0" type="radio" id="nao" />
									<label style="margin: 15px" for="nao">Não</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<button class="btn btn-info">
								<i class="material-icons">save</i>
								<span>ADD Reembolso</span> 
							</button>
						</div>						
					</div>
				</div>
			</div>
		</div>
		<!-- FIM CABEÇALHO PADRAO -->			
	</form>
</section>
@endsection
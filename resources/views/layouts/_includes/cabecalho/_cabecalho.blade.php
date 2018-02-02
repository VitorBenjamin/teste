<div class="body">
	<div class="row clearfix">
		<div class="col-md-2">
			<label for="origem_despesa">Origem da Despesa</label>
			<select id="origem_despesa" name="origem_despesa" class="form-control show-tick" required>
				<option value="CLIENTE" {{ old('origem_despesa') == "CLIENTE" ? 'selected' : '' }}>CLIENTE</option>
				<option value="ESCRITÓRIO" {{ old('origem_despesa') == "ESCRITÓRIO" ? 'selected' : '' }}>ESCRITÓRIO</option>

			</select>
		</div>
		<div class="col-md-3">
			<label id="label" for="cliente" class="label2">Cliente</label>
			<select id="cliente" name="clientes_id" class="selectpicker form-control show-tick" data-size="5" data-live-search="true">
				<option value="">SELECIONE</option>
				@foreach ($clientes as $cliente)
				<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-3">
			<label id="label" for="solicitante" class="label2">Solicitante</label>
			<select id="solicitante" name="solicitantes_id" class="form-control show-tick" data-size="5" data-live-search="true" required>
				<option value="">SELECIONE</option>
				{{-- @foreach ($solicitantes as $solicitante)
				<option value="{{ $solicitante->id }}">{{ $solicitante->nome }}</option>
				@endforeach --}}
			</select>
		</div>
		<div class="col-md-3">
			<div class="form-line">
				<label class="form-label">Número de Processo</label>
				<input type="text" id="processo" name="processo" class="form-control" autocomplete="off" placeholder="Ex: 9999999-99.9999.9.99.9999" />
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-2">
			<label for="area_atuacoes">Área de Atendimento</label>
			<select id="area_atuacoes" name="area_atuacoes_id" class="form-control show-tick" data-live-search="true" required>
				<option value="">SELECIONE</option>
				@foreach ($areas as $area)
				<option value="{{ $area->id }}">{{ $area->tipo }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-2">
			<label for="contrato">Tipo de Contrato</label>
			<select id="contrato" name="contrato" class="form-control show-tick" data-live-search="true" required>
				<option value="">SELECIONE</option>
				<option value="CONSULTIVO">CONSULTIVO</option>
				<option value="CONTENSIOSO">CONTENSIOSO</option>
				<option value="PREVENTIVO">PREVENTIVO</option>
			</select>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<fieldset>
					<legend>Urgência</legend>
				</fieldset>
				<input name="urgente" value="1" type="radio" id="sim" />
				<label style="margin: 15px 15px 0px 0px" for="sim">Sim</label>
				<input name="urgente" value="0" type="radio" id="nao" checked />
				<label style="margin: 15px 15px 0px 0px" for="nao">Não</label>
			</div>
		</div>
		<div class="col-md-2" style="margin-top: 20px">
			<button class="btn bg-green waves-effect">
				<i class="material-icons">send</i>
				<span>CADASTRAR SOLICITAÇÃO</span> 
			</button>
		</div> 
	</div>
</div>
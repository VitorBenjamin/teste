<div class="body">
	<div class="row clearfix">
		<div class="col-md-2">
			<label for="origem_despesa">Origem da Despesa</label>
			<select id="origem_despesa" name="origem_despesa" class="form-control show-tick">
				<option value="CLIENTE" {{ old('origem_despesa') == "CLIENTE" ? 'selected' : '' }}>CLIENTE</option>
				<option value="ESCRITÓRIO" {{ old('origem_despesa') == "ESCRITÓRIO" ? 'selected' : '' }}>ESCRITÓRIO</option>

			</select>
		</div>
		<div class="col-md-3">
			<label for="clientes">Cliente</label>
			<select id="clientes" name="clientes_id" class="selectpicker with-ajax with-ajax after-init form-control show-tick" data-live-search="true">
			</select>
		</div>
		<div class="col-md-3">
			<label for="solicitantes">Solicitante</label>
			<select id="solicitantes" name="solicitantes_id" class="form-control show-tick" data-live-search="true" required>
				{{old('solicitantes')}}
			</select>
		</div>
		<div class="demo-masked-input">
			<div class="col-md-3">
				<b>Número de Processo</b>
				<div class="input-group">
					<div class="form-line">
						<input type="text" name="processo" class="form-control processo" placeholder="Ex: 9999999-99.9999.9.99.9999" />
					</div>
				</div>
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
			<select id="contrato" name="contrato" class="form-control show-tick" data-live-search="true" >
				<option value="">SELECIONE</option>
				<option value="CONSULTIVO">CONSULTIVO</option>
				<option value="CONTECIOSO">CONTECIOSO</option>
				<option value="PREVENTIVO">PREVENTIVO</option>
			</select>
		</div>
		<div class="col-md-3">
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
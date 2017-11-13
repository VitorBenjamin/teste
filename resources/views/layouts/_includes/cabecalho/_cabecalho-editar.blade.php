<div class="body">
	<div class="row clearfix">
		<div class="col-md-2">
			<label for="origem_despesa">Origem de Despesa</label>
			<select id="origem_despesa" name="origem_despesa" class="form-control show-tick">
				<option value="CLIENTE" {{ $solicitacao->origem_despesa == "CLIENTE" ? 'selected' : '' }}>CLIENTE</option>
				<option value="ESCRITÓRIO" {{ $solicitacao->origem_despesa == "ESCRITÓRIO" ? 'selected' : '' }}>ESCRITÓRIO</option>
			</select>
		</div>
		<div class="col-md-3">
			<label id="label" for="clientes">Cliente</label>
			<select id="clientes" name="clientes_id" class="selectpicker form-control show-tick" data-live-search="true">
				@if(!empty($cliente[0]))
				<option value="{{$solicitacao->clientes_id}}">{{ $cliente[0]->nome }}</option>
				@endif
			</select>
		</div>
		<div class="col-md-3">
			<label for="solicitantes">Solicitante</label>
			<select id="solicitantes" name="solicitantes_id" class="form-control show-tick" data-live-search="true">
				<option value="{{$solicitacao->solicitantes_id}}">{{ $solicitante[0]->nome }}</option>
			</select>
		</div>
		<div class="demo-masked-input">
			<div class="col-md-4">
				<b>Número de Processo</b>
				<div class="input-group">
					<div class="form-line">
						@if($solicitacao->processo != null)
						<input type="text" name="processo" value="{{$solicitacao->processo->codigo}}" class="form-control processo" placeholder="Ex: 9999999-99.9999.9.99.9999" />
						@else
						<input type="text" name="processo" class="form-control processo" placeholder="Ex: 9999999-99.9999.9.99.9999" />
						@endif

					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="row clearfix">
		<div class="col-md-3">
			<label for="area_atuacoes_id">Área de Atendimento</label>
			<select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-live-search="true">									
				@foreach ($areas as $area)
				@if($solicitacao->area_atuacoes_id == $area->id)
				<option value="{{$solicitacao->area_atuacoes_id}}">{{ $area->tipo }}</option>
				@break							
				@endif
				@endforeach

				<option value="null">SELECIONE</option>

				@foreach ($areas as $area)
				@unless ($solicitacao->area_atuacoes_id == $area->id)
				<option value="{{ $area->id }}">{{ $area->tipo }}</option>
				@endunless												
				@endforeach
			</select>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="contrato">Tipo de Contrato</label>
				<select id="contrato" name="contrato" class="form-control show-tick" data-live-search="true">
					<option value="CONSULTIVO" {{ $solicitacao->contrato == "CONSULTIVO" ? 'selected' : '' }}>CONSULTIVO</option>
					<option value="CONTECIOSO" {{ $solicitacao->contrato == "CONTECIOSO" ? 'selected' : '' }}>CONTECIOSO</option>
					<option value="PREVENTIVO" {{ $solicitacao->contrato == "PREVENTIVO" ? 'selected' : '' }}>PREVENTIVO</option>
				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<fieldset>
					<legend style="margin: 0">Urgência</legend>
				</fieldset>
				@if ($solicitacao->urgente == true)
				<input name="urgente" value="1" type="radio" id="sim" checked />
				<label style="margin: 15px 15px 0px 0px" for="sim">Sim</label>
				<input name="urgente" value="0" type="radio" id="nao" />
				<label style="margin: 15px 15px 0px 0px" for="nao">Não</label>
				@else
				<input name="urgente" value="1" type="radio" id="sim" />
				<label style="margin: 15px 15px 0px 0px" for="sim">Sim</label>
				<input name="urgente" value="0" type="radio" id="nao" checked />
				<label style="margin: 11px 15px 0px 0px" for="nao">Não</label>
				@endif
			</div>
		</div>
		<div class="col-md-4" style="margin-top: 10px">
			<button class="btn bg-green waves-effect" style="margin-top: 10px" >
				<i class="material-icons">update</i>
				<span>ATUALIZAR CABEÇALHO</span> 
			</button>
			<a  style="margin-top: 10px" href="{{ route('solicitacao.andamento',$solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
				<i class="material-icons">send</i>
				<span>ENVIAR</span>
			</a>
		</div>		
		
																	
	</div>			
</div>
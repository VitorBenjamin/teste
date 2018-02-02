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
			<label id="label" for="cliente">Cliente</label>
			<select id="cliente" name="clientes_id" class="selectpicker form-control show-tick" data-live-search="true">
				<!-- @if(!empty($cliente[0]))
				<option value="{{$solicitacao->clientes_id}}">{{ $cliente[0]->nome }}</option>
				@endif -->
				@foreach ($clientes as $cliente)
				<option value="{{ $cliente->id }}" {{$solicitacao->clientes_id == $cliente->id ? 'selected' : '' }} >{{ $cliente->nome }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-3">
			<label id="label" for="solicitante" class="label2">Solicitante</label>
			<select id="solicitante" name="solicitantes_id" class="form-control show-tick" data-live-search="true">
				@if($solicitacao->solicitantes_id != null)
				<option value="{{ $solicitante->id }}">{{ $solicitante->nome }}</option>
				@endif
				{{-- @foreach ($solicitantes as $solicitante)
				<option value="{{ $solicitante->id }}" {{$solicitacao->solicitantes_id == $solicitante->id ? 'selected' : '' }} >{{ $solicitante->nome }}</option>
				@endforeach --}}
			</select>
		</div>
		<!-- <div class="demo-masked-input">
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
		</div> -->
		<div class="col-md-3">
			<div class="form-line">
				<label class="form-label">Número de Processo</label>
				<input type="text" id="processo" value="{{$solicitacao->processo == null ? '' : $solicitacao->processo->codigo}}" name="processo" class="form-control" autocomplete="off" placeholder="Ex: 9999999-99.9999.9.99.9999" />
			</div>
		</div>

	</div>
	<div class="row clearfix">
		<div class="col-md-3">
			<label for="area_atuacoes_id">Área de Atendimento</label>
			<select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-live-search="true" required>									
				<option value="">SELECIONE</option>
				@foreach ($areas as $area)
				<option value="{{$area->id}}" {{$solicitacao->area_atuacoes_id == $area->id ? 'selected' : ''}}>{{ $area->tipo }}</option>						
				@endforeach
			</select>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="contrato">Tipo de Contrato</label>
				<select id="contrato" name="contrato" class="form-control show-tick" data-live-search="true">
					<option value="CONSULTIVO" {{ $solicitacao->contrato == "CONSULTIVO" ? 'selected' : '' }}>CONSULTIVO</option>
					<option value="CONTENSIOSO" {{ $solicitacao->contrato == "CONTENSIOSO" ? 'selected' : '' }}>CONTENSIOSO</option>
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
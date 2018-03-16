@foreach ($solicitacao->translado as $translado)
<tr>
	<td>{{date('d/m/Y',strtotime($translado->data_translado))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>TRANSLADO - {{$translado->origem}} - {{$translado->destino}} - Km {{$translado->distancia}} {{$solicitacao->processo == null ? '- SEM PROCESSO' : '- N° PROCE. '.$solicitacao->processo->codigo}}</td>
	<td>R$ {{$translado->estornado ? -$translado->distancia*$solicitacao->cliente->valor_km : $translado->distancia*$solicitacao->cliente->valor_km}}</td>
	@if($exibir)
	<td>
		<input type="checkbox" class="checkbox" id="translado_{{$translado->id}}" name="desativar[]" value="{{$translado->id}}-Translado" {{$translado->estornado ? 'checked' : ''}}>
		<label for="translado_{{$translado->id}}"></label>
		<input type="checkbox" class="checkbox" id="_translado_{{$translado->id}}" name="_desativar[]" value="{{$translado->id}}-Translado">
	</td>
	@else
	<td>
		@if($translado->estornado)
		SIM
		@else
		NÃO
		@endif
	</td>
	@endif
</tr>
@endforeach	

@foreach($solicitacao->despesa as $despesa)
<tr>
	<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>{{$despesa->tipo_comprovante}} - {{$despesa->descricao}} {{$solicitacao->processo == null ? '- SEM PROCESSO' : '- N° PROCE. '.$solicitacao->processo->codigo}}</td>
	<td>R$ {{$despesa->estornado ? -$despesa->valor : $despesa->valor}}</td> 
	@if($exibir)
	<td>
		<input type="checkbox" class="checkbox" id="despesa_{{$despesa->id}}" name="desativar[]" value="{{$despesa->id}}-Despesa" {{$despesa->estornado ? 'checked' : ''}}>
		<label for="despesa_{{$despesa->id}}"></label>
		<input type="checkbox" class="checkbox" id="_despesa_{{$despesa->id}}" name="_desativar[]" value="{{$despesa->id}}-Despesa">
	</td>
	@else
	<td>
		@if($despesa->estornado)
		SIM
		@else
		NÃO
		@endif
	</td>                     
	@endif
</tr>
@endforeach
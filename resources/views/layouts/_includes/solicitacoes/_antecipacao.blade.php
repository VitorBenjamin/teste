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
		NÂO
		@endif
	</td>
	@endif
</tr>
@endforeach
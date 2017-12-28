@foreach($solicitacao->despesa as $despesa)
<tr>
	<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>{{$despesa->tipo_comprovante}} - {{$despesa->descricao}} - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{$despesa->estornado ? -$despesa->valor : $despesa->valor}}</td>
	<td>
		<input type="checkbox" class="checkbox" id="despesa_{{$despesa->id}}" name="desativar[]" value="{{$despesa->id}}-Despesa">
		<label for="despesa_{{$despesa->id}}"></label>		
	</td>
</tr>
@endforeach
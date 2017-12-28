@foreach ($solicitacao->viagem as $key => $viagem)
<tr>
	<td>{{date('d/m/Y',strtotime($viagem->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>VIAGEM - {{$viagem->origem}} <-> {{date('d-m-Y',strtotime($viagem->data_ida))}} - {{$viagem->destino}} <-> {{$viagem->data_volta == null ? date('d-m-Y',strtotime($viagem->data_volta)) : 'SOMENTE IDA' }} - {{$viagem->bagagem == 1 ? 'BAGAGEM '.$viagem->kg.'Kg' : 'BAGAGEM NÃO'}} - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{ $viagem->estornado == 1 ? -$viagem->valor : $viagem->valor}}</td>
	<td>
			<input type="checkbox" class="checkbox" id="viagem_{{$viagem->id}}" name="desativar[]" value="{{$viagem->id}}-Viagem">
			<label for="viagem_{{$viagem->id}}"></label>
	</td>
</tr>

@endforeach

@foreach($solicitacao->despesa as $despesa)
<tr>
	<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>{{$despesa->tipo_comprovante}} - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{$despesa->estornado ? -$despesa->valor : $despesa->valor}}</td>
	<td>
			<input type="checkbox" class="checkbox" id="despesa_{{$despesa->id}}" name="desativar[]" value="{{$despesa->id}}-Despesa">
			<label for="despesa_{{$despesa->id}}"></label>
	</td>       
</tr>
@endforeach
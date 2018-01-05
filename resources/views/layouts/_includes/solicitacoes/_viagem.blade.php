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
<tr>
	<td>{{date('d/m/Y',strtotime($viagem->hospedagens->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>HOSPEDAGEM - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{$viagem->hospedagens->estornado ? -$viagem->hospedagens->custo_hospedagem : $viagem->hospedagens->custo_hospedagem}}</td>
	<td>
		<input type="checkbox" class="checkbox" id="hospedagem_{{$viagem->hospedagens->id}}" name="desativar[]" value="{{$viagem->hospedagens->id}}-Hospedagem">
		<label for="hospedagem_{{$viagem->hospedagens->id}}"></label>
	</td>       
</tr>
<tr>
	<td>{{date('d/m/Y',strtotime($viagem->locacoes->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>LOCAÇÃO - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{$viagem->locacoes->estornado ? -$viagem->locacoes->custo_locacao : $viagem->locacoes->custo_locacao}}</td>
	<td>
		<input type="checkbox" class="checkbox" id="locacao_{{$viagem->locacoes->id}}" name="desativar[]" value="{{$viagem->locacoes->id}}-Locacao">
		<label for="locacao_{{$viagem->locacoes->id}}"></label>
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
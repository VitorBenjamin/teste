
@foreach ($solicitacao->viagem as $key => $viagem)
<tr>
	<td></td>
	<td>{{date('d/m/y',strtotime($viagem->comprovante->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>VIAGEM - {{$viagem->origem}} <-> {{date('d-m-Y',strtotime($viagem->data_ida))}} - {{$viagem->destino}} <-> {{$viagem->data_volta == null ? date('d-m-Y',strtotime($viagem->data_volta)) : 'SOMENTE IDA' }} - {{$viagem->bagagem == 1 ? 'BAGAGEM '.$viagem->kg.'Kg' : 'BAGAGEM NÃO'}} - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{ $viagem->total}}</td>
</tr>
@if($viagem->hospedagem == 1)
<tr>
	<td></td>
	<td>{{date('d-m-y',strtotime($viagem->comprovante->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>HOSPEDAGEM - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{$viagem->comprovante->custo_hospedagem }}</td>
</tr>
@endif
@if($viagem->locacao == 1)
<tr>
	<td></td>
	<td>{{date('d/m/y',strtotime($viagem->comprovante->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>LOCAÇÃO - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{ $viagem->comprovante->custo_locacao}}</td>
</tr>
@endif
@endforeach

@foreach($solicitacao->despesa as $despesa)
<tr>
	<td></td>
	<td>{{date('d/m/y',strtotime($despesa->data_despesa))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>{{$despesa->tipo_comprovante}} - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{$despesa->valor}}</td>                      
</tr>
@endforeach
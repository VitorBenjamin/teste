@foreach ($solicitacao->translado as $translado)
<tr>
	<td></td>
	<td>{{date('d/m/y',strtotime($translado->data_translado))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>TRANSLADO - {{$translado->origem}} - {{$translado->destino}} - Km {{$translado->distancia}} - N° PROCE. {{$solicitacao->processo->codigo}} </td>
	<td>R$ {{$translado['valor']}}</td>
</tr>
@endforeach	

@foreach($solicitacao->despesa as $despesa)
<tr>
	<td></td>
	<td>{{date('d/m/y',strtotime($despesa->data_despesa))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>{{$despesa->tipo_comprovante}} - {{$despesa->descricao}} - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{$despesa->valor}}</td>                      
</tr>
@endforeach
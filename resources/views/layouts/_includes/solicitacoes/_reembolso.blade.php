@foreach ($solicitacao->translado as $translado)
<tr>
	<td>{{date('d/m/Y',strtotime($translado->data_translado))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>TRANSLADO - {{$translado->origem}} - {{$translado->destino}} - Km {{$translado->distancia}} - N° PROCE. {{$solicitacao->processo->codigo}} </td>
	<td>R$ {{$translado['valor']}}</td>
</tr>
@endforeach	

@foreach($solicitacao->despesa as $despesa)
<tr>
	<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>{{$despesa->tipo_comprovante}} - {{$despesa->descricao}} - N° PROCE. {{$solicitacao->processo->codigo}}</td>
	<td>R$ {{$despesa->valor}}</td>                      
</tr>
@endforeach
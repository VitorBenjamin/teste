@foreach ($solicitacao->guia as $guia)
<tr>
	<td>{{date('d/m/Y',strtotime($guia->data_limite))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>GUIA - {{$guia->perfil_pagamento}}-{{$guia->banco}} - {{$guia->tipoGuia()->first()->descricao}}</td>
	<td>R$ {{ $guia->valor}} </td>
</tr>
@endforeach	
@foreach ($solicitacao->guia as $guia)
<tr>
	<td>{{date('d/m/Y',strtotime($guia->data_limite))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>GUIA - {{$guia->perfil_pagamento}} - {{$guia->banco}} - {{$guia->tipoGuia()->first()->descricao}}</td>
	<td>R$ {{ $guia->estornado ? -$guia->valor : $guia->valor}} </td>
	<td>
		<input type="checkbox" class="checkbox" id="guia_{{$guia->id}}" name="desativar[]" value="{{$guia->id}}-Guia">
		<label for="guia_{{$guia->id}}"></label>
	</td>
</tr>
@endforeach	
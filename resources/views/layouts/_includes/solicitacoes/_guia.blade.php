@foreach ($solicitacao->guia as $guia)
<tr>
	<td>{{date('d/m/Y',strtotime($guia->data_limite))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>GUIA - {{$guia->perfil_pagamento}} - {{$guia->banco}} - {{$guia->tipoGuia()->first()->descricao}}</td>
	<td>R$ {{ $guia->estornado ? -$guia->valor : $guia->valor}} </td>
	@if($exibir)
	<td>
		<input type="checkbox" class="checkbox" id="guia_{{$guia->id}}" name="desativar[]" value="{{$guia->id}}-Guia" {{$guia->estornado ? 'checked' : ''}}>
		<label for="guia_{{$guia->id}}"></label>
		<input type="checkbox" class="checkbox" id="_guia_{{$guia->id}}" name="_desativar[]" value="{{$guia->id}}-Guia">
	</td>
	@else
	<td>
		@if($guia->estornado)
		SIM
		@else
		NÃO
		@endif
	</td>
	@endif
</tr>
@endforeach	
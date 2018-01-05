@foreach ($solicitacao->compra as $compra)
@foreach ($compra->cotacao as $cotacao)
@if($cotacao->data_compra)
<tr>
	<td>{{date('d/m/Y',strtotime($cotacao->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>COMPRA - {{$compra->descricao}} - {{$cotacao->fornecedor}} - {{$cotacao->quantidade}} Unid.</td>
	<td>R$ {{ $compra->estornado ? -$cotacao->valor : $cotacao->valor}} </td>
	<td>
		<input type="checkbox" class="checkbox" id="compra_{{$compra->id}}" name="desativar[]" value="{{$compra->id}}-Compra">
		<label for="compra_{{$compra->id}}"></label>
	</td>
</tr>
@endif
@endforeach
@endforeach	
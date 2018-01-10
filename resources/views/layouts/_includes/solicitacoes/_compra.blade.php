@foreach ($solicitacao->compra as $compra)
@foreach ($compra->cotacao as $cotacao)
@if($cotacao->data_compra)
<tr>
	<td>{{date('d/m/Y',strtotime($cotacao->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>COMPRA - {{$compra->descricao}} - {{$cotacao->fornecedor}} - {{$cotacao->quantidade}} Unid.</td>
	<td>R$ {{ $compra->estornado ? -$cotacao->valor : $cotacao->valor}} </td>
	@if($exibir)
	<td>
		<input type="checkbox" class="checkbox" id="compra_{{$compra->id}}" name="desativar[]" value="{{$compra->id}}-Compra" {{$compra->estornado ? 'checked' : ''}}>
		<label for="compra_{{$compra->id}}"></label>		
		<input type="checkbox" class="checkbox" id="_compra_{{$compra->id}}" name="_desativar[]" value="{{$compra->id}}-Compra">

	</td>
	@else
	<td>
		@if($compra->estornado)
		SIM
		@else
		NÃO
		@endif
	</td>
	@endif
</tr>
@endif
@endforeach
@endforeach	
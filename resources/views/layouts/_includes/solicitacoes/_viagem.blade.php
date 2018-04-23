@foreach ($solicitacao->viagem as $key => $viagem)
<tr>
	<td>{{date('d/m/Y',strtotime($viagem->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>VIAGEM - {{$viagem->origem}} <-> {{date('d-m-Y',strtotime($viagem->data_ida))}} - {{$viagem->destino}} <-> {{$viagem->data_volta ? date('d-m-Y',strtotime($viagem->data_volta)) : 'SÓ IDA' }} - {{$viagem->bagagem == 1 ? 'BAGAGEM '.$viagem->kg.'Kg' : 'BAGAGEM NÃO'}} {{$solicitacao->processo ? '- N° PROCE. '.$solicitacao->processo->codigo : '- SEM PROCESSO'}}</td>
	<td>R$ {{ $viagem->estornado == 1 ? -$viagem->valor : $viagem->valor}}</td>
	@if($exibir)
	<td>
		<input type="checkbox" class="checkbox" id="viagem_{{$viagem->id}}" name="desativar[]" value="{{$viagem->id}}-Viagem" {{$viagem->estornado ? 'checked' : ''}}>
		<label for="viagem_{{$viagem->id}}"></label>
		<input type="checkbox" class="checkbox" id="_viagem_{{$viagem->id}}" name="_desativar[]" value="{{$viagem->id}}-Viagem">
	</td>
	@else
	<td>
		@if($viagem->estornado)
		SIM
		@else
		NÃO
		@endif
	</td>
	@endif
</tr>
<tr>
	<td>{{date('d/m/Y',strtotime($viagem->hospedagens->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>HOSPEDAGEM {{$solicitacao->processo ? '- N° PROCE.'.$solicitacao->processo->codigo : ''}}</td>
	<td>R$ {{$viagem->hospedagens->estornado ? -$viagem->hospedagens->custo_hospedagem : $viagem->hospedagens->custo_hospedagem}}</td>
	@if($exibir)
	<td>
		<input type="checkbox" class="checkbox" id="hospedagem_{{$viagem->hospedagens->id}}" name="desativar[]" value="{{$viagem->hospedagens->id}}-Hospedagem" {{$viagem->hospedagens->estornado ? 'checked' : ''}}>
		<label for="hospedagem_{{$viagem->hospedagens->id}}"></label>
		<input type="checkbox" class="checkbox" id="_hospedagem_{{$viagem->hospedagens->id}}" name="_desativar[]" value="{{$viagem->hospedagens->id}}-Hospedagem">
	</td>
	@else
	<td>
		@if($viagem->hospedagens->estornado)
		SIM
		@else
		NÃO
		@endif
	</td> 
	@endif      
</tr>
@if ($viagem->locacoes)
<tr>
	<td>{{date('d/m/Y',strtotime($viagem->locacoes->data_compra))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>LOCAÇÃO {{$viagem->locacoes->observacao}}{{$solicitacao->processo ? '- N° PROCE.'.$solicitacao->processo->codigo : ''}}</td>
	<td>R$ {{$viagem->locacoes->estornado ? -$viagem->locacoes->valor : $viagem->locacoes->valor}}</td>
	@if($exibir)
	<td>
		<input type="checkbox" class="checkbox" id="locacao_{{$viagem->locacoes->id}}" name="desativar[]" value="{{$viagem->locacoes->id}}-Locacao" {{$viagem->locacoes->estornado ? 'checked' : ''}}>
		<label for="locacao_{{$viagem->locacoes->id}}"></label>
		<input type="checkbox" class="checkbox" id="_locacao_{{$viagem->locacoes->id}}" name="_desativar[]" value="{{$viagem->locacoes->id}}-Locacao">
	</td>
	@else
	<td>
		@if($viagem->locacoes->estornado)
		SIM
		@else
		NÃO
		@endif
	</td>
	@endif       
</tr>
@endif
@endforeach
@if ($solicitacao->despesa)
@foreach($solicitacao->despesa as $despesa)
<tr>
	<td>{{date('d/m/Y',strtotime($despesa->data_despesa))}}</td>
	<td>{{ $solicitacao->codigo}}</td>
	<td>{{$despesa->tipo_comprovante}} {{$solicitacao->processo ? '- N° PROCE.'.$solicitacao->processo->codigo : ''}}</td>
	<td>R$ {{$despesa->estornado ? -$despesa->valor : $despesa->valor}}</td>
	@if($exibir)
	<td>
		<input type="checkbox" class="checkbox" id="despesa_{{$despesa->id}}" name="desativar[]" value="{{$despesa->id}}-Despesa" {{$despesa->estornado ? 'checked' : ''}}>
		<label for="despesa_{{$despesa->id}}"></label>
		<input type="checkbox" class="checkbox" id="_despesa_{{$despesa->id}}" name="_desativar[]" value="{{$despesa->id}}-Despesa">
	</td>
	@else
	<td>
		@if($despesa->estornado)
		SIM
		@else
		NÃO
		@endif
	</td> 
	@endif      
</tr>
@endforeach
@endif
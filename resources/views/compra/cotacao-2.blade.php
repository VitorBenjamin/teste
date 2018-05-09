@foreach ($compra->cotacao as $cotacao)
@if ($solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_finalizado') && $cotacao->aprovado == 0)

@else
<tr>
	<td>{{date('d/m/Y',strtotime($cotacao->data_cotacao))}}</td>
	<td>{{$cotacao->descricao}}</td>
	<td>{{$cotacao->fornecedor}}</td>
	<td>{{$cotacao->quantidade}}</td>
	<td>R$ {{$cotacao->valor}}</td>
	<td>
		@if($cotacao->anexo_comprovante)
		<div class="zoom-gallery" style="float: left; margin-right: 10px;">
			<a href="{{$cotacao->anexo_comprovante}}" data-source="{{$cotacao->anexo_comprovante}}" title="COMPROVANTE - {{$cotacao->tipo_comprovante}} - {{date('d/m/Y',strtotime($cotacao->data_cotacao))}}" style="width:32px;height:32px;">
				<img class="img_popup" src="{{$cotacao->anexo_comprovante}}" width="32" height="32">
			</a>
		</div>
		@else
		Nenhum Arquivo Anexado
		@endif
	</td>
	<td>
		<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('compra.deletarCotacao', $cotacao->id)}}"><i class="material-icons">delete_sweep</i></a>
	</td>
</tr>
@endif
@endforeach		
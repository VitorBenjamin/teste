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
		@if($solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_administrativo') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_recorrente_financeiro'))
		<a style="margin-left: 10px" class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{ route('compra.deletarCotacao', $cotacao->id)}}"><i class="material-icons">delete_sweep</i></a>
		@elseif($solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_recorrente') && Auth::user()->hasRole('COORDENADOR'))

		@if ($cotacao->aprovado)
		<i class="material-icons" style="font-size: 34px;color: green;">done_all</i>
		@else
		<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" href="{{ route('compra.aprovarCotacao', ['compraId' => $compra->id,'cotacaoId' => $cotacao->id])}}" role="button"><i class="material-icons">attach_money</i></a>
		@endif
		@elseif($solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado') && Auth::user()->hasRole('ADMINISTRATIVO'))
		<div class="icon-button-demo">
			<a data-toggle="modal" data-target="#comprovante{{$compra->id}}" class="btn bg-grey btn-circle waves-effect waves-circle waves-float">
				<i class="material-icons">attach_file</i>
			</a>
		</div>
		@endif
	</td>
</tr>
@endif
@endforeach		
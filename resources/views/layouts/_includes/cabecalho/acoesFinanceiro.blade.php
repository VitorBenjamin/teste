@if(($solicitacao->tipo == "COMPRA" || $solicitacao->tipo == "VIAGEM") && $solicitacao->status()->get()[0]->descricao == config('constantes.status_andamento_administrativo') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_recorrente_financeiro'))
	<a href="{{ route('solicitacao.andamento',$solicitacao->id) }}" class="btn bg-teal waves-effect" role="button">
		<i class="material-icons">low_priority</i>
		<span>ENVIAR PARA APROVAÇÂO</span>
	</a>
	<a  data-toggle="modal" data-target="#modalDevolver" class="btn bg-lime waves-effect" role="button">
		<i class="material-icons">report_problem</i>
		<span>DEVOLVER</span>
	</a>
@elseif($solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado') || $solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado_etapa2'))

	@if($solicitacao->tipo == "VIAGEM" && $solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado'))
		<?php $teste = true ?>
		@if($solicitacao->viagem[0]->passagem)
			@if(!$solicitacao->viagem[0]->anexo_passagem)
				<?php $teste = false ?>
			@endif
		@endif
		@if($solicitacao->viagem[0]->hospedagens)
			@if(!$solicitacao->viagem[0]->hospedagens->anexo_hospedagem)
				<?php $teste = false ?>
			@endif
		@endif
		@if($solicitacao->viagem[0]->locacoes)
			@if(!$solicitacao->viagem[0]->locacoes->anexo_locacao)
				<?php $teste = false ?>
			@endif
		@endif
		<a href="{{ route('solicitacao.finalizar',$solicitacao->id) }}" class="btn bg-light-green waves-effect {{$teste ? '' : 'not-active'}}" role="button" {{$teste ? '' : 'disabled'}}>
			<i class="material-icons">done_all</i>
			<span>FINALIZAR</span>
		</a>
	@elseif($solicitacao->tipo == "VIAGEM" && $solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado_etapa2'))
		<a href="{{ route('solicitacao.finalizar',$solicitacao->id) }}" class="btn bg-light-green waves-effect {{count($solicitacao->comprovante) == 0 ? 'not-active' : ''}}" role="button" {{count($solicitacao->comprovante) == 0 ? 'disabled' : ''}}>
			<i class="material-icons">done_all</i>
			<span>FINALIZAR</span>
		</a>
	@elseif($solicitacao->tipo == "ANTECIPAÇÃO" && $solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado_etapa2'))
		<a href="{{ route('solicitacao.finalizar', $solicitacao->id) }}" class="btn bg-light-green waves-effect {{count($solicitacao->comprovante) == 0 ? 'not-active' : ''}}" role="button" {{count($solicitacao->comprovante) == 0 ? 'disabled' : ''}}>
			<i class="material-icons">done_all</i>
			<span>FINALIZAR</span>
		</a>
	@elseif($solicitacao->tipo == "ANTECIPAÇÃO" && $solicitacao->status()->get()[0]->descricao == config('constantes.status_aprovado'))
		<a href="{{ route('solicitacao.finalizar', $solicitacao->id) }}" class="btn bg-light-green waves-effect {{count($solicitacao->antecipacao[0]->anexo_comprovante) ? '' : 'not-active'}}" role="button" {{count($solicitacao->antecipacao[0]->anexo_comprovante) ? '' : 'disabled'}}>
			<i class="material-icons">done_all</i>
			<span>FINALIZAR</span>
		</a>
	@elseif($solicitacao->tipo == "GUIA")
	<?php foreach ($solicitacao->guia as $guia): ?>
		@if($guia->anexo_comprovante == null)
			<a href="{{ route('solicitacao.finalizar', $solicitacao->id) }}" class="btn bg-light-green waves-effect not-active" role="button" disabled>
				<i class="material-icons">done_all</i>
				<span>FINALIZAR</span>
			</a>
		@break
		@endif
			<a href="{{ route('solicitacao.finalizar', $solicitacao->id) }}" class="btn bg-light-green waves-effect" role="button">
				<i class="material-icons">done_all</i>
				<span>FINALIZAR</span>
			</a>
	<?php endforeach ?>
	@else
		<a href="{{ route('solicitacao.finalizar', $solicitacao->id) }}" class="btn bg-light-green waves-effect {{count($solicitacao->comprovante) ? '' : 'not-active'}}" role="button" {{count($solicitacao->comprovante) ? '' : 'disabled'}}>
			<i class="material-icons">done_all</i>
			<span>FINALIZAR</span>
		</a>
	@endif

	@if($solicitacao->tipo == "COMPRA" && $solicitacao->status()->get()[0]->descricao != config('constantes.status_aprovado')) 
		<a data-toggle="modal" data-target="#modalDevolver" class="btn bg-lime waves-effect {{$finalizar ? '' : 'not-active'}}" role="button" {{$finalizar ? '' : 'disabled'}}>
			<i class="material-icons">report_problem</i>
			<span>DEVOLVER</span>
		</a>
	@endif

@endif

@role(['FINANCEIRO','ADMINISTRATIVO'])
	@if($solicitacao->status()->get()[0]->descricao == config('constantes.status_finalizado'))
		<a href="{{ route('relatorio.relatorioIndividual',$solicitacao->id) }}" class="btn bg-light-green waves-effect" role="button" target="_blank">
			<i class="material-icons">insert_photo</i>
			<span>RELÁTORIO DA SOLICITAÇÃO</span>
		</a>
	@endif
@endrole
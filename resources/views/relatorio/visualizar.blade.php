@extends('layouts.app')
@section('content')
<script type="text/javascript">
	var rota = "{{route('relatorio.relatorioGeral',$relatorio->id)}}";
</script>
<section class="content">
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="header">
				@if(Session::has('flash_message'))
				<div align="center" class="{{ Session::get('flash_message')['class'] }}" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('flash_message')['msg'] }}
				</div>								
				@endif
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<a style="margin-bottom: 10px;" href="{{ route('relatorio.listar')}}" class="btn bg-grey waves-effect" role="button">
						<i class="material-icons">keyboard_backspace</i>
						<span>VOLTAR</span>
					</a>
					<h2>
						RELÁTORIO GERAL DOS GASTOS DA <span class="badge bg-cyan" style="padding: 8px 7px; font-size: 15px">{{$relatorio->cliente->nome}} DE {{date('d/m/Y',strtotime($data_inicial))}} ATÉ {{date('d/m/Y',strtotime($relatorio->data))}}</span>
						<span class="badge bg-green" style="padding: 8px 7px; font-size: 15px">FINAL</span>
					</h2>
				</div>
				<div class="body">
					<table id="tableTeste" class="table table-bordered table-striped table-hover dataTable relatorio-final">
						<thead>
							<tr>
								<th class="uk-date-column">DATA</th>
								<th>CÓDIGO</th>
								<th>DADOS GERAIS</th>
								<th style="width: 50px">VALORES</th>
								<th style="width: 50px">ESTORNADOS</th>

							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th></th>
								<th style="white-space: nowrap;"></th>
								<th colspan="2" style="text-align:right;white-space: nowrap;"></th>
							</tr>
						</tfoot>
						<tbody style="font-size: 13px;">
							@foreach ($solicitacoes as $solicitacao)
							@if($solicitacao->tipo == "REEMBOLSO")

							@include('layouts._includes.solicitacoes._reembolso')

							@elseif($solicitacao->tipo == "GUIA")

							@include('layouts._includes.solicitacoes._guia')

							@elseif($solicitacao->tipo == "VIAGEM")

							@include('layouts._includes.solicitacoes._viagem')

							@elseif($solicitacao->tipo == "COMPRA")

							@include('layouts._includes.solicitacoes._compra')

							@elseif($solicitacao->tipo == "ANTECIPAÇÃO")

							@include('layouts._includes.solicitacoes._antecipacao')

							@endif
							@endforeach                                
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
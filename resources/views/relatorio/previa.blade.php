@extends('layouts.app')
@section('content')
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
						GERAR RELÁTORIO GERAL DOS GASTOS DA <span class="badge bg-blue-grey" style="padding: 8px 7px; font-size: 15px">{{$cliente->nome}} DE {{date('d/m/Y',strtotime($data_inicial))}} ATÉ {{date('d/m/Y',strtotime($data_final))}}</span>
						<span class="badge bg-teal" style="padding: 8px 7px; font-size: 15px">PRÉVIO</span>
					</h2>
					<br>
					<form id="relatorioForm2" action="{{ route('relatorio.salvar')}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="data_inicial" value="{{$data_inicial}}">
						<input type="hidden" name="data_final" value="{{$data_final}}">
						<input type="hidden" name="clientes_id" value="{{$cliente->id}}">
						<div class="col-md-6">
							<div class="form-group">
								<div class="form-line">
									<label for="observacao">Observação</label>
									<input type="text" name="observacao" class="form-control" placeholder=""/>
								</div>
							</div>
						</div>
					</form>
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a class="btn bg-orange waves-effect submit" role="button">
							<i class="material-icons">money_off</i>
							<span>ESTORNAR GASTOS SELECIONADOS</span>
						</a>
						<a class="btn bg-blue waves-effect submit2" role="button">
							<i class="material-icons">save</i>
							<span>SALVAR RELÁTORIO</span>
						</a>
						<!-- <a class="btn bg-green waves-effect submit2" role="button">
							<i class="material-icons">save</i>
							<span>FINALIZAR RELÁTORIO</span>
						</a> -->
					</div>
				</div>

				<div class="body">
					<form id="relatorioForm" action="{{ route('relatorio.extornar')}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<table id="tableTeste" class="table table-bordered table-striped table-hover dataTable relatorio-previa">
							<thead>
								<tr>
									<th class="uk-date-column">DATA</th>
									<th>CÓDIGO</th>
									<th>DADOS GERAIS</th>
									<th style="width: 50px">VALORES</th>
									<th style="width: 80px, padding-right: 0px;">ESTORNADAS</th>
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
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
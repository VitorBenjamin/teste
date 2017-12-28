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
					<h2>
						Gerar Relátorio
					</h2>
					<br>
					<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
						<a class="btn bg-light-green waves-effect submit" role="button">
							<i class="material-icons">money_off</i>
							<!-- <span class="hidden-xs">ADD</span> -->
							<span>EXTORNAR DESPESAS SELECIONADAS</span>
						</a>
					</div>
				</div>
				<div class="body">
					<form id="relatorioForm" action="{{ route('relatorio.extornar')}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<table id="tableTeste" class="table table-bordered table-striped table-hover dataTable relatorio-dataTable">
							<thead>
								<tr>
									<th class="uk-date-column">DATA</th>
									<th>CÓDIGO</th>
									<th>DADOS GERAIS</th>
									<th style="width: 50px">VALORES</th>
									<th style="width: 80px, padding-right: 0px;">
										AÇÕES 
										<input id="product_all" name="product_all" class="checked_all" type="checkbox">
										<label for="product_all"></label>
									</th>
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
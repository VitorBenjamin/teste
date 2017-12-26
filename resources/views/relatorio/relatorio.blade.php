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
				</div>
				<div class="body">
					<form action="{{ route('relatorio.gerar')}}" method="GET">
						{{ csrf_field() }}
						<table class="table table-bordered table-striped table-hover dataTable js-exportable">
							<thead>
								<tr>
									<th class="uk-date-column">DATA</th>
									<th>CÓDIGO</th>
									<th>DADOS GERAIS</th>
									<th style="width: 110px">VALORES</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th></th>
									<th></th>
									<th style="white-space: nowrap;"></th>
									<th style="text-align:right;white-space: nowrap;"></th>
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
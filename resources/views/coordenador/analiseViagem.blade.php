@extends('layouts.app')
@section('content')

<section class="content">
	<div class="block-header">
		<h2>Dados da Solicitação</h2>			
	</div>
	
	<!-- INCIO CABEÇALHO PADRAO -->
	@include('layouts._includes.cabecalho._cabecalho_analise')
	<!-- FIM CABEÇALHO PADRAO -->


<!-- LISTAGEM DA VIAGEM  -->
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					LISTAGEM DA VIAGEM
				</h2>
			</div>
			<div class="body">
				<table class="table table-bordered table-striped nowrap table-hover dataTable js-basic-example ">
					<thead>
						<tr>
							<th></th>
							<th>Origem</th>
							<th>Data Ida</th>
							<th>Destino</th>
							<th>Data Volta</th>	
							<th>Hospedagem</th>
							<th>Bagagem</th>
							<th>Kg</th>
							<th>Locação</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th></th>
							<th>Origem</th>
							<th>Data Ida</th>
							<th>Destino</th>
							<th>Data Volta</th>	
							<th>Hospedagem</th>
							<th>Bagagem</th>
							<th>Kg</th>
							<th>Locação</th>
						</tr>
					</tfoot>
					<tbody>
						@foreach ($solicitacao->viagem as $viagem)
						<tr>
							<td></td>
							<td>{{$viagem->origem}}</td>
							<td>{{date('d/m/y',strtotime($viagem->data_ida))}}</td>
							<td>{{$viagem->destino}}</td>
							<td>{{date('d/m/y',strtotime($viagem->data_volta))}}</td>
							<td>{{$viagem->hospedagem == 1 ? 'SIM' : 'NÃO'}}</td>
							<td>{{$viagem->bagagem == 1 ? 'SIM' : 'NÃO'}}</td>
							<td>{{$viagem->kg}}</td>
							<td>{{$viagem->locacao == 1 ? 'SIM' : 'NÃO'}}</td>
						</tr>
						@endforeach														
					</tbody>
				</table>
			</div>
		</div>
	</div> 												
</div>
<!-- FIM LISTAGEM DA VIAGEM  -->
</section>
@endsection
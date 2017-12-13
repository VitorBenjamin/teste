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
						Listagem dos Clientes do Sistema
						<!-- <small>Different sizes and widths</small> -->
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
						<thead>
							<tr>
								<th></th>
								<th>Nome</th>
								<th>Valor do KM</th>
								<th>Saldo</th>
								<th>Unidade</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Nome</th>
								<th>Valor do KM</th>
								<th>Saldo</th>
								<th>Unidade</th>
								<th>Ações</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($clientes as $cliente)
							<tr>
								<td></td>
								<td>{{$cliente->nome}}</td>
								<td>{{$cliente->valor_km}}</td>
								<td>{{$cliente->saldo}}</td>
								<td>{{$cliente->unidade->localidade}}</td>
								<td class="acoesTD">
									<div class="icon-button-demo" >
										<!-- REDIRECIONAMENTO DINAMICO POR PARAMETRO -->
										<a href="{{ route('cliente.editar', $cliente->id)}}" class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EDITAR {{$cliente->nome}}">
											<i class="material-icons">search</i>
										</a>									
									</div>
								</td>
							</tr>					
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
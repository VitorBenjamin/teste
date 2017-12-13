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
						Cadastrar Novo Cliente
						<!-- <small>Different sizes and widths</small> -->
					</h2>					
				</div>
				<div class="body">
					<form action="{{ route('cliente.salvar') }}" method="POST">
						{{ csrf_field() }}
						<div class="row clearfix">							
							<div class="col-md-3">
								<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="nome">Nome do Cliente *</label>
										<input id="nome" type="text" class="form-control" name="nome" value="" required>
									</div>
									@if ($errors->has('nome'))
									<span class="help-block">
										<strong>{{ $errors->first('nome') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-float">
									<label for="unidades_id">Unidades</label>
									<select id="unidades_id" name="unidades_id" class="form-control show-tick" data-live-search="true" required>
										@foreach ($unidades as $unidade)
										<option value="{{ $unidade->id }}" >{{ $unidade->localidade }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<b>Valor do KM</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input type="numeric" name="valor_km" style="text-align:right" name="valor_km" class="form-control" size="11"  value="" onKeyUp="moeda(this);" required>
									</div>
								</div>							
							</div>
							<div class="col-md-2">
								<b>Saldo</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input type="numeric" name="saldo" style="text-align:right" name="saldo" class="form-control" size="11"  value="" onKeyUp="moeda(this);" required>
									</div>
								</div>							
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-md-offset-4">
								<button class="btn btn-block btn-lg btn-primary waves-effect">
									<i class="material-icons">send</i>
									CADASTRAR CLIENTE
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
				</div>
				<div class="body">
					<h2>
						Listagem dos Clientes do Sistema
						<!-- <small>Different sizes and widths</small> -->
					</h2>
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
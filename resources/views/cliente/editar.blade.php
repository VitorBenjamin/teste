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
	<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
		<a data-toggle="modal" data-target="#addSolicitante" class="btn bg-light-green waves-effect" role="button">
			<i class="material-icons">exposure_plus_1</i>
			<!-- <span class="hidden-xs">ADD</span> -->
			<span>Solicitante</span>
		</a>
	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Dados da {{$cliente->nome}}
						<!-- <small>Different sizes and widths</small> -->
					</h2>
				</div>
				<div class="body">
					<form action="{{ route('cliente.atualizar',$cliente->id) }}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="row clearfix">							
							<div class="col-md-3">
								<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="nome">Nome do Cliente *</label>
										<input id="nome" type="text" class="form-control" name="nome" value="{{ $cliente->nome }}" required>
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
										<option value="{{ $unidade->id }}" {{$unidade->id == $cliente->unidades_id ? 'selected' : ''}}>{{ $unidade->localidade }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group{{ $errors->has('logradouro') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="logradouro">Logradrouro</label>
										<input id="logradouro" type="text" class="form-control" name="logradouro" value="{{$cliente->logradouro}}">
									</div>
									@if ($errors->has('logradouro'))
									<span class="help-block">
										<strong>{{ $errors->first('logradouro') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="cep">CEP</label>
										<input id="cep" type="text" class="form-control" name="cep" value="{{$cliente->cep}}">
									</div>
									@if ($errors->has('cep'))
									<span class="help-block">
										<strong>{{ $errors->first('cep') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-2">
								<b>Valor do KM</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input type="numeric" name="valor_km" style="text-align:right" name="valor_km" class="form-control" size="11"  value="{{$cliente->valor_km}}" onKeyUp="moeda(this);" required>
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
										<input type="numeric" name="saldo" style="text-align:right" name="saldo" class="form-control" size="11"  value="{{$cliente->saldo}}" onKeyUp="moeda(this);" required>
									</div>
								</div>							
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-md-offset-4">
								<button class="btn btn-block btn-lg btn-primary waves-effect">
									<i class="material-icons">update</i>
									ATUALIZAR DADOS DA {{$cliente->nome}}
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
					<h2>
						LISTAGEM DOS SOLICITANTES
					</h2>
				</div>
				<div class="body">
					<table class="table table-bordered table-striped table-hover dataTable">
						<thead>
							<tr>
								<th>Nome</th>
								<th>E-mail</th>
								<th>Telefone</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Nome</th>
								<th>E-mail</th>
								<th>Telefone</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($cliente->solicitante as $key => $soli)
							<tr>
								<td>{{$soli->nome}}</td>
								<td>{{$soli->email}}</td>
								<td>{{$soli->telefone}}</td>
							</tr>							
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="modal fade" id="addSolicitante" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="defaultModalLabel">ADICIONAR NOVO SOLICITANTE</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('solicitante.salvar')}}" method="POST">
					{{ csrf_field() }}
					<div class="row clearfix">							
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
								<div class="form-line">
									<label for="nome">Nome do Solicitante *</label>
									<input id="nome" type="text" class="form-control" name="nome" value="" required>
								</div>
								@if ($errors->has('nome'))
								<span class="help-block">
									<strong>{{ $errors->first('nome') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }} form-float">
								<div class="form-line">
									<label for="cliente">Cliente</label>
									<select id="cliente" name="clientes_id" class="form-control show-tick not-active" data-live-search="true" data-size="7">
										<option value="{{ $cliente->id }}" selected>{{ $cliente->nome }}</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} form-float">
								<div class="form-line">
									<label>E-mail do Solicitante</label>
									<input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" autofocus>
									@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }} form-float">
								<div class="form-line">
									<label>Telefone(s)</label>
									<input id="telefone" type="type" class="form-control" name="telefone" value="{{ old('telefone') }}">
									@if ($errors->has('telefone'))
									<span class="help-block">
										<strong>{{ $errors->first('telefone') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div> 
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-info">
								<i class="material-icons">send</i>
								<span>CRIAR SOLICITANTE</span>
							</button>
						</div>
						<!-- <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button> -->
						<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


@endsection

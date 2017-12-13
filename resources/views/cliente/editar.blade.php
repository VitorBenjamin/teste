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
</section>
@endsection

@extends('layouts.app')
@section('content')
<script type="text/javascript">
	function formatarValor(valor){
		valor = valor.replace(".","");
		valor = valor.replace(",",".");
		return valor;
	}
	valor = "1.200,00";
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
					<h2>
						Listagem do Usuários do Sistema
						<!-- <small>Different sizes and widths</small> -->
					</h2>
				</div>
				<div class="body">
					<h3>Segurança</h3>
					<br>
					<form method="POST" action="{{ route('register') }}">
						<div class="row clearfix">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="nome">Nome do Advogado *</label>
										<input id="nome" type="text" class="form-control" name="nome" value="{{ $user->nome }}" required>
										@if ($errors->has('nome'))
										<span class="help-block">
											<strong>{{ $errors->first('nome') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="emial">E-mail *</label>
										<input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>		
										@if ($errors->has('email'))
										<span class="help-block">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<label class="form-label">Senha *</label>
										<input id="password" type="password" class="form-control" name="password" required>
										@if ($errors->has('password'))
										<span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-float">
									<div class="form-line">
										<label class="form-label">Confirmação de Senha *</label>
										<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
									</div>
								</div>
							</div>
						</div>
						<h3>INFORMAÇÔES</h3>
						<br>
						<div class="row clearfix">
							<div class="col-md-6">
								<div class="form-group">
									<label for="area_atuacoes_id">Área de Origem</label>
									<select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-dropup-auto="false" data-size="5" data-live-search="true" required>
										@foreach ($areas as $area)
										<option value="{{ $area->id }}" {{$user->area_atuacoes_id == $area->id ? 'selected' : ''}}>{{ $area->tipo }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="unidades_id">Unidade e Origem</label>
									<select id="unidades_id" name="unidades_id" class="form-control show-tick" data-dropup-auto="false" data-size="5" data-live-search="true" required>
										@foreach ($unidades as $unidade)
										<option value="{{ $unidade->id }}" {{$user->unidades_id == $unidade->id ? 'selected' : ''}}>{{ $unidade->localidade }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="cpf">CPF do Advogado *</label>
										<input id="cpf" type="text" class="form-control" name="cpf" value="{{ $user->cpf }}" required>
										@if ($errors->has('cpf'))
										<span class="help-block">
											<strong>{{ $errors->first('cpf') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="telefone">Telefone *</label>
										<input id="telefone" type="type" class="form-control" name="telefone" value="{{ $user->telefone }}" required>
										@if ($errors->has('telefone'))
										<span class="help-block">
											<strong>{{ $errors->first('telefone') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
						</div>
						@if($user->hasRole('COORDENADOR'))
						<h3>DADOS COORDENADOR</h3>
						<br>
						<table id="aberto" class="table table-bordered table-striped table-hover dataTable js-basic-example">
							<thead>
								<tr>
									<th></th>
									<th>ID</th>
									<th>Área de Atendimento</th>
									<th>Unidades de Coordenação</th>
									<th>Aprovação (Mínimo)</th>
									<th>Aprovação (Máximo)</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($user->limites as $limite)
								<tr>
									<td></td>
									<td>{{ $limite->id }}</td>
									<td>{{ $limite->areas->tipo}}</td>
									<td>
										@foreach($limite->unidades as $unidade)
										{{$unidade->localidade}};
										@endforeach
									</td>
									<td>{{ 'R$ '.number_format($limite->de, 2, ',', '.') }}</td>
									<td>{{ 'R$ '.number_format($limite->ate, 2, ',', '.') }}</td>
								</tr>
								@endforeach                                    
							</tbody>
						</table>
						@endif
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection
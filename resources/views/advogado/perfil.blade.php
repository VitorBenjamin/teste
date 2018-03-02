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
						Edição de Perfil - {{$user->nome}}
						<!-- <small>Different sizes and widths</small> -->
					</h2>
				</div>
				<div class="body">
					<form action="{{ route('user.atualizarPerfil') }}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="row clearfix">
							<h3 style="text-align:center"><i class="material-icons">arrow_downward</i>Segurança</h3>
							<br>
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="nome">Nome do Advogado *</label>
										<input id="nome" type="text" class="form-control" name="nome" value="{{ $user->nome }}" required>
									</div>
									@if ($errors->has('nome'))
									<span class="help-block">
										<strong>{{ $errors->first('nome') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="emial">E-mail *</label>
										<input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>		
									</div>
									@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<label class="form-label">Nova Senha *</label>
										<input id="password" type="password" class="form-control" name="password">
									</div>
									@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-float">
									<div class="form-line">
										<label class="form-label">Confirmar Nova Senha *</label>
										<input id="password-confirm" type="password" class="form-control" name="password_confirmation">
									</div>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-4 col-md-offset-4">
								<button class="btn btn-block btn-lg btn-primary waves-effect">
									<i class="material-icons">arrow_upward</i>
									ATUALIZAR DADOS
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
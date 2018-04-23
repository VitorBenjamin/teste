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
										<label for="email">E-mail *</label>
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
						<div class="row clearfix">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
									<div class="form-line">
										<label for="cpf">CPF do Advogado *</label>
										<input id="cpf" type="text" class="form-control" name="cpf" value="{{ auth()->user()->cpf }}" >
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
										<input id="telefone" type="type" class="form-control" name="telefone" value="{{ auth()->user()->telefone }}" >
										@if ($errors->has('telefone'))
										<span class="help-block">
											<strong>{{ $errors->first('telefone') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
						</div>
						@if (auth()->user()->dados)
						<div class="row clearfix">
							<div class="col-sm-2">
								<div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="rg" type="text" class="form-control" name="rg" value="{{ auth()->user()->dados == null ? '' : auth()->user()->dados->rg }}"  autofocus>
										<label class="form-label">RG</label>
										@if ($errors->has('rg'))
										<span class="help-block">
											<strong>{{ $errors->first('rg') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group{{ $errors->has('data_inicial') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="data_inicial" type="text" class="form-control" name="data_inicial" value="{{ auth()->user()->dados == null ? '' : date('d-m-Y', strtotime(auth()->user()->dados->data_inicial)) }}" pattern="\d{2}-\d{2}-\d{4}" title="Digite a Data no formato dd-mm-aaaa" autofocus>
										<label class="form-label">Data Inicial</label>
										@if ($errors->has('data_inicial'))
										<span class="help-block">
											<strong>{{ $errors->first('data_inicial') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group{{ $errors->has('data_nascimento') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="data_nascimento" type="text" class="form-control" name="data_nascimento" value="{{ auth()->user()->dados == null ? '' : date('d-m-Y', strtotime(auth()->user()->dados->data_nascimento)) }}" pattern="\d{2}-\d{2}-\d{4}" title="Digite a Data no formato dd-mm-aaaa" autofocus>
										<label class="form-label">Data Nascimento</label>
										@if ($errors->has('data_nascimento'))
										<span class="help-block">
											<strong>{{ $errors->first('data_nascimento') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group{{ $errors->has('estado_civil') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="estado_civil" type="text" class="form-control" name="estado_civil" value="{{ auth()->user()->dados == null ? '' : auth()->user()->dados->estado_civil }}"  autofocus>
										<label class="form-label">Estado Civil</label>
										@if ($errors->has('estado_civil'))
										<span class="help-block">
											<strong>{{ $errors->first('estado_civil') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form-group{{ $errors->has('dados_bancarios') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="dados_bancarios" type="text" class="form-control" name="dados_bancarios" value="{{ auth()->user()->dados == null ? '' : auth()->user()->dados->dados_bancarios }}"  autofocus>
										<label class="form-label">Dados Bancário</label>
										@if ($errors->has('dados_bancarios'))
										<span class="help-block">
											<strong>{{ $errors->first('dados_bancarios') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>                                    
						</div>
						<div class="row clearfix">
							<div class="col-sm-2">
								<div class="form-group{{ $errors->has('funcao') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="funcao" type="text" class="form-control" name="funcao" value="{{ auth()->user()->dados == null ? '' : auth()->user()->dados->funcao }}"  autofocus>
										<label class="form-label">Função</label>
										@if ($errors->has('funcao'))
										<span class="help-block">
											<strong>{{ $errors->first('funcao') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group{{ $errors->has('cidade') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="cidade" type="text" class="form-control" name="cidade" value="{{ auth()->user()->dados == null ? '' : auth()->user()->dados->cidade }}"  autofocus>
										<label class="form-label">Cidade</label>
										@if ($errors->has('cidade'))
										<span class="help-block">
											<strong>{{ $errors->first('cidade') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-1">
								<div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="estado" type="text" class="form-control" name="estado" value="{{ auth()->user()->dados == null ? '' : auth()->user()->dados->estado }}"  autofocus>
										<label class="form-label">Estado</label>
										@if ($errors->has('estado'))
										<span class="help-block">
											<strong>{{ $errors->first('estado') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="cep" type="text" class="form-control" name="cep" value="{{ auth()->user()->dados == null ? '' : auth()->user()->dados->cep }}"  autofocus>
										<label class="form-label">CEP</label>
										@if ($errors->has('cep'))
										<span class="help-block">
											<strong>{{ $errors->first('cep') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group{{ $errors->has('endereco') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="endereco" type="text" class="form-control" name="endereco" value="{{ auth()->user()->dados == null ? '' : auth()->user()->dados->endereco }}"  autofocus>
										<label class="form-label">Endereço</label>
										@if ($errors->has('endereco'))
										<span class="help-block">
											<strong>{{ $errors->first('endereco') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-sm-5">
								<div class="form-group{{ $errors->has('viagem') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="viagem" type="text" class="form-control" name="viagem" value="{{ auth()->user()->dados == null ? '' : auth()->user()->dados->viagem }}" autofocus>
										<label class="form-label">Viagem</label>
										@if ($errors->has('viagem'))
										<span class="help-block">
											<strong>{{ $errors->first('viagem') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
						</div>
						@endif
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
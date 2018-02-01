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
						Listagem do Usuários do Sistema
						<!-- <small>Different sizes and widths</small> -->
					</h2>
				</div>
				<div class="body">
					<form action="{{ route('user.atualizar',$user->id) }}" method="POST">
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
										<label class="form-label">Senha *</label>
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
										<label class="form-label">Confirmação de Senha *</label>
										<input id="password-confirm" type="password" class="form-control" name="password_confirmation">
									</div>
								</div>
							</div>
						</div>
						
						<div class="row clearfix">
							<h3 style="text-align:center"><i class="material-icons">arrow_downward</i>INFORMAÇÔES</h3>
							<br>
							<div class="col-md-6">
								<label for="area_atuacoes_id">Área de Origem</label>
								<select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-dropup-auto="false" data-size="5" data-live-search="true" required>
									@foreach ($areas as $area)
									<option value="{{ $area->id }}" {{$user->area_atuacoes_id == $area->id ? 'selected' : ''}}>{{ $area->tipo }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-6">
								<label for="unidades_id">Unidade e Origem</label>
								<select id="unidades_id" name="unidades_id" class="form-control show-tick" data-dropup-auto="false" data-size="5" data-live-search="true" required>
									@foreach ($unidades as $unidade)
									<option value="{{ $unidade->id }}" {{$user->unidades_id == $unidade->id ? 'selected' : ''}}>{{ $unidade->localidade }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-md-6">
								<div class="form-group form-float">
									<label for="clientes">Clientes</label>
									<select id="clientes" name="clientes[]" class="form-control show-tick" data-container="body" data-dropup-auto="false" data-size="5" data-actions-box="true" data-live-search="true" data-none-selected-text="Nenhum Registro Selecionado" data-none-results-text="Nenhum Resultado Encontrado" data-deselect-all-text="DESELECIONAR TODOS" data-select-all-text="SELECIONAR TODOS" multiple required>
										@foreach ($clientes as $cliente)
										<option value="{{ $cliente->id }}" {{$user->clientes->contains($cliente->id) == true ? 'selected' : ''}}>{{ $cliente->nome }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-float">
									<label for="advogados">Advogados</label>
									<select id="advogados" name="advogados[]" class="form-control show-tick"data-container="body" data-dropup-auto="false" data-size="5" data-actions-box="true" data-live-search="true" data-none-selected-text="Nenhum Registro Selecionado" data-none-results-text="Nenhum Resultado Encontrado" data-deselect-all-text="DESELECIONAR TODOS" data-select-all-text="SELECIONAR TODOS" multiple required>
										@foreach ($advogados->user as $advogado)
										<option value="{{ $advogado->id }}" {{$user->users->contains($advogado->id) == true ? 'selected' : ''}}>{{ $advogado->nome }}</option>
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
						<div class="row clearfix">
							<div class="col-sm-2">
								<div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="rg" type="text" class="form-control" name="rg" value="{{ $user->dados->rg }}" required autofocus>
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
								<div class="form-group{{ $errors->has('data_nascimento') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="data_nascimento" type="text" class="form-control" name="data_nascimento" value="{{ $user->dados->data_nascimento }}" required autofocus>
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
										<input id="estado_civil" type="text" class="form-control" name="estado_civil" value="{{ $user->dados->estado_civil }}" required autofocus>
										<label class="form-label">Estado Civil</label>
										@if ($errors->has('estado_civil'))
										<span class="help-block">
											<strong>{{ $errors->first('estado_civil') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group{{ $errors->has('funcao') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="funcao" type="text" class="form-control" name="funcao" value="{{ $user->dados->funcao }}" required autofocus>
										<label class="form-label">Função</label>
										@if ($errors->has('funcao'))
										<span class="help-block">
											<strong>{{ $errors->first('funcao') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group{{ $errors->has('dados_bancarios') ? ' has-error' : '' }} form-float">
									<div class="form-line">
										<input id="dados_bancarios" type="text" class="form-control" name="dados_bancarios" value="{{ $user->dados->dados_bancarios }}" required autofocus>
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
										<input id="funcao" type="text" class="form-control" name="funcao" value="{{ $user->dados->funcao }}" required autofocus>
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
										<input id="cidade" type="text" class="form-control" name="cidade" value="{{ $user->dados->cidade }}" required autofocus>
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
										<input id="estado" type="text" class="form-control" name="estado" value="{{ $user->dados->estado }}" required autofocus>
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
										<input id="cep" type="text" class="form-control" name="cep" value="{{ $user->dados->cep }}" required autofocus>
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
										<input id="endereco" type="text" class="form-control" name="endereco" value="{{ $user->dados->endereco }}" required autofocus>
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
										<input id="viagem" type="text" class="form-control" name="viagem" value="{{ $user->dados->viagem }}" required autofocus>
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
						<div class="row">
							<div class="col-md-4 col-md-offset-4">
								<button class="btn btn-block btn-lg btn-primary waves-effect">
									<i class="material-icons">arrow_upward</i>
									ATUALIZAR DADOS DO DRª {{$user->nome}}
								</button>
							</div>
						</div>
					</form>
					@if($user->hasRole('COORDENADOR'))
					<h3 style="text-align:center"> <i class="material-icons">arrow_downward</i>LIMITES DO COORDENADOR</h3>
					<div class="row">
						<div class="col-md-2 col-md-offset-5">
							<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
								<a data-toggle="modal" data-target="#modalAdd" class="btn bg-red waves-effect" role="button">
									<i class="material-icons">plus_one</i>
									<span>ADD LIMITAÇÂO</span>
								</a>
							</div>
						</div>
					</div>
					<br>
					<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="largeModalLabel">Editar um Antecipação</h4>
								</div>
								<form action="{{ route('limite.add', $user->id)}}" method="POST">
									{{ csrf_field() }}
									{{ method_field('PUT') }}
									<div class="modal-body">				
										<div class="row clearfix">
											<div class="col-md-2">
												<label for="area_atuacoes_id">Área de Atendimento</label>
												<select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-actions-box="true"  data-live-search="true" data-none-selected-text="Nenhum Registro Selecionado">
													@foreach ($areas as $area)
													<option value="{{ $area->id }}">{{ $area->tipo }}</option>
													@endforeach
												</select>
											</div>
											<div class="col-md-6">
												<label for="unidades_limite">Unidades de Coordenação</label>
												<select id="unidades_limite" name="unidades_limite[]" class="form-control show-tick" data-dropup-auto="false" multiple data-actions-box="true"  data-live-search="true" data-none-selected-text="Nenhum Registro Selecionado">
													@foreach ($unidades as $unidade)
													<option value="{{ $unidade->id }}">{{ $unidade->localidade }}</option>
													@endforeach
												</select>
											</div>
											<div class="col-md-2">
												<b>Aprovação Financeira (Mínimo)</b>
												<div class="input-group">
													<span class="input-group-addon">
														R$
													</span>
													<div class="form-line">
														<input id="de" type="numeric" name="de" style="text-align:right" class="form-control" size="11" onKeyUp="moeda(this);" required />
													</div>
													@if ($errors->has('de'))
													<span class="help-block">
														<strong>{{ $errors->first('de') }}</strong>
													</span>
													@endif
												</div>
											</div>
											<div class="col-md-2">
												<b>Aprovação Financeira (Máximo)</b>
												<div class="input-group">
													<span class="input-group-addon">
														R$
													</span>
													<div class="form-line">
														<input id="ate" type="numeric" name="ate" style="text-align:right" class="form-control" size="11" onKeyUp="moeda(this);" required/>
													</div>
													@if ($errors->has('ate'))
													<span class="help-block">
														<strong>{{ $errors->first('ate') }}</strong>
													</span>
													@endif
												</div>
											</div>
										</div>
										<div class="modal-footer">	
											<button class="btn btn-primary btn-lg waves-effect">
												<i class="material-icons">update</i>
												<span>ATUALIZAR LIMITE</span> 
											</button>												
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
										</div>
									</div>
								</form>	
							</div>
						</div>
					</div>
					<!-- INICIO TABELA COM AS RESTRIÇÔES POR VALOR -->
					<table class="table table-bordered table-striped table-hover dataTable table-simples">
						<thead>
							<tr>
								<th></th>
								<th>Área. Atend..</th>
								<th>Unidades de Coordenação</th>
								<th>Aprov. Min</th>
								<th>Aprov. Max</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($user->limites as $limite)
							<tr>
								<td></td>
								<td>{{ $limite->areas->tipo}}</td>
								<td>
									@foreach($limite->unidades as $unidade)
									{{$unidade->localidade}};
									@endforeach
								</td>
								<td>{{ 'R$ '.number_format($limite->de, 2, ',', '.') }}</td>
								<td>{{ 'R$ '.number_format($limite->ate, 2, ',', '.') }}</td>
								<td class="acoesTD">
									<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#modal{{$limite->id}}" role="button">
										<i class="material-icons">mode_edit</i>
									</a>
									<a href="{{ route('user.deletarLimite',['user' => $user->id,'limite' =>$limite->id]) }}" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="EXCLUIR LIMITE {{$limite->id}}">
										<i class="material-icons">delete_forever</i>
									</a>
								</td>
							</tr>
							@endforeach                                    
						</tbody>
					</table>
					<!-- FIM TABELA COM AS RESTRIÇÔES POR VALOR -->
					
					<!-- INICIO SESSÂO COM AS RESTRIÇÔES POR CLIENTE E ADVOGADOS-->
					
					<!-- FIM SESSÂO COM AS RESTRIÇÔES POR CLIENTE E ADVOGADOS-->

					@endif
				</div>				
			</div>
		</div>
	</div>


	<!-- MODAL EDIÇÂO DO LIMITE -->
	@foreach ($user->limites as $limite) 
	<div class="modal fade" id="modal{{$limite->id}}" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">Editar um Antecipação</h4>
				</div>
				<form action="{{ route('limite.atualizar', $limite->id)}}" method="POST">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="modal-body">				
						<div class="row clearfix">
							<div class="col-md-2">
								<label for="area_atuacoes_id">Área de Atendimento</label>
								<select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-actions-box="true"  data-live-search="true" data-none-selected-text="Nenhum Registro Selecionado">
									@foreach ($areas as $area)
									<option value="{{ $area->id }}" {{$limite->area_atuacoes_id ==  $area->id ? 'selected' : ''}}>{{ $area->tipo }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-6">
								<label for="unidades_limite">Unidades de Coordenação</label>
								<select id="unidades_limite" name="unidades_limite[]" class="form-control show-tick" data-dropup-auto="false" multiple data-actions-box="true"  data-live-search="true" data-none-selected-text="Nenhum Registro Selecionado">
									@foreach ($unidades as $unidade)
									@if($limite->unidades->contains($unidade->id))
									<option value="{{ $unidade->id }}" selected>{{ $unidade->localidade }}</option>
									@else
									<option value="{{ $unidade->id }}">{{ $unidade->localidade }}</option>
									@endif
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<b>Aprovação Financeira (Mínimo)</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input id="de" type="numeric" name="de" value="{{ $limite->de }}" style="text-align:right" class="form-control" size="11" onKeyUp="moeda(this);" required />
									</div>
									@if ($errors->has('de'))
									<span class="help-block">
										<strong>{{ $errors->first('de') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-2">
								<b>Aprovação Financeira (Máximo)</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input id="ate" type="numeric" name="ate" value="{{ $limite->ate }}" style="text-align:right" class="form-control" size="11" onKeyUp="moeda(this);" required/>
									</div>
									@if ($errors->has('ate'))
									<span class="help-block">
										<strong>{{ $errors->first('ate') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div>
						<div class="modal-footer">	
							<button class="btn btn-primary btn-lg waves-effect">
								<i class="material-icons">update</i>
								<span>ATUALIZAR LIMITE</span> 
							</button>												
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	@endforeach 
	<!-- FIM MODAL DE EDIÇÂO DO LIMITE -->

</section>
@endsection
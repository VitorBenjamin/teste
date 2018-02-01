@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                REGISTRO DE ADVOGADO
            </h2>
        </div>
        <!-- Advanced Form Example With Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Preencha os Dados Com Atenção</h2>
                    </div>
                    <div class="body">
                        <form id="wizard_with_validation" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="role" value="{{config('constantes.user_advogado')}}">
                            <h3>SEGURANÇA</h3>
                            <fieldset>
                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }} form-float">
                                    <div class="form-line">
                                        <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" required autofocus>
                                        <label class="form-label">Nome*</label>
                                        @if ($errors->has('nome'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} form-float">
                                    <div class="form-line">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        <label class="form-label">E-mail*</label>
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} form-float">
                                    <div class="form-line">
                                        <input id="password" type="password" class="form-control" name="password" required>
                                        <label class="form-label">Senha*</label>
                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        <label class="form-label">Confirmação de Senha*</label>
                                    </div>
                                </div>
                            </fieldset>              
                            <h3>INFORMAÇÔES</h3>
                            <fieldset>
                                <div class="form-group form-float">
                                    <label for="area_atuacoes_id">Área de Atendimento</label>
                                    <select id="area_atuacoes_id" name="area_atuacoes_id" class="form-control show-tick" data-container="body" data-dropup-auto="false" data-size="5" data-live-search="true" required>
                                        <option value="">SELECIONE</option>
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group form-float">
                                    <label for="unidades_id">Unidades</label>
                                    <select id="unidades_id" name="unidades_id" class="form-control show-tick" data-container="body" data-dropup-auto="false" data-size="5" data-live-search="true" required>
                                        <option value="">SELECIONE</option>
                                        @foreach ($unidades as $unidade)
                                        <option value="{{ $unidade->id }}">{{ $unidade->localidade }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }} form-float">
                                    <div class="form-line">
                                        <input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}" required autofocus>
                                        <label class="form-label">CPF*</label>
                                        @if ($errors->has('cpf'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cpf') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }} form-float">
                                    <div class="form-line">
                                        <input id="telefone" type="type" class="form-control" name="telefone" value="{{ old('telefone') }}" required>
                                        <label class="form-label">Telefone*</label>
                                        @if ($errors->has('telefone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('telefone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
                            <h3>INFORMAÇÔES COMPLEMENTARES</h3>
                            <fieldset>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }} form-float">
                                            <div class="form-line">
                                                <input id="rg" type="text" class="form-control" name="rg" value="{{ old('rg') }}" autofocus>
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
                                                <input id="data_nascimento" type="text" class="form-control" name="data_nascimento" value="{{ old('data_nascimento') }}" autofocus>
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
                                                <input id="estado_civil" type="text" class="form-control" name="estado_civil" value="{{ old('estado_civil') }}" autofocus>
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
                                                <input id="funcao" type="text" class="form-control" name="funcao" value="{{ old('funcao') }}" autofocus>
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
                                                <input id="dados_bancarios" type="text" class="form-control" name="dados_bancarios" value="{{ old('dados_bancarios') }}" autofocus>
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
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group{{ $errors->has('funcao') ? ' has-error' : '' }} form-float">
                                            <div class="form-line">
                                                <input id="funcao" type="text" class="form-control" name="funcao" value="{{ old('funcao') }}" autofocus>
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
                                                <input id="cidade" type="text" class="form-control" name="cidade" value="{{ old('cidade') }}" autofocus>
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
                                                <input id="estado" type="text" class="form-control" name="estado" value="{{ old('estado') }}" autofocus>
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
                                                <input id="cep" type="text" class="form-control" name="cep" value="{{ old('cep') }}" autofocus>
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
                                                <input id="endereco" type="text" class="form-control" name="endereco" value="{{ old('endereco') }}" autofocus>
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
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group{{ $errors->has('viagem') ? ' has-error' : '' }} form-float">
                                            <div class="form-line">
                                                <input id="viagem" type="text" class="form-control" name="viagem" value="{{ old('viagem') }}" autofocus>
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
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Advanced Form Example With Validation -->
    </div>
</section>
@endsection

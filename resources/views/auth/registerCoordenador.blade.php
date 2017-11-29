@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                CADASTRO DE COORDENADOR
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
                            <input type="hidden" name="role" value="{{config('constantes.user_coordenador')}}">
                            <h3>SEGURANÇA</h3>
                            <fieldset>
                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }} form-float">
                                    <div class="form-line">
                                        <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" required autofocus>
                                        <label class="form-label">Nome do Advogado*</label>
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
                                    <select id="area_atuacoes_id" name="area_atuacoes_id" data-container="body" class="form-control show-tick" data-dropup-auto="false" data-size="5" data-live-search="true" required>
                                        <option value="">SELECIONE</option>
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group form-float">
                                    <label for="unidades_id">Unidades</label>
                                    <select id="unidades_id" name="unidades_id" data-container="body" class="form-control show-tick" data-dropup-auto="false" data-size="5" data-live-search="true" required>
                                        <option value="">SELECIONE</option>
                                        @foreach ($unidades as $unidade)
                                        <option value="{{ $unidade->id }}">{{ $unidade->localidade }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }} form-float">
                                    <div class="form-line">
                                        <input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}" required autofocus>
                                        <label class="form-label">CPF do Advogado*</label>
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
                            <h3>Dados Coordenador</h3>
                            <fieldset>
                                <div class="form-group form-float">
                                    <label for="area_atuacoes_limite">Área de Atendimento</label>
                                    <select id="area_atuacoes_limite" name="area_atuacoes_limite[]" data-container="body" class="form-control show-tick" data-dropup-auto="false" multiple data-actions-box="true"  data-live-search="true" data-none-selected-text="Nenhum Registro Selecionado">
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group form-float">
                                    <label for="unidades_limite">Unidades</label>
                                    <select id="unidades_limite" name="unidades_limite[]" data-container="body" class="form-control show-tick" data-dropup-auto="false" multiple data-actions-box="true"  data-live-search="true" data-none-selected-text="Nenhum Registro Selecionado">
                                        @foreach ($unidades as $unidade)
                                        <option value="{{ $unidade->id }}">{{ $unidade->localidade }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('de') ? ' has-error' : '' }} form-float">
                                    <div class="form-line">
                                        <input id="de" type="text" class="form-control" name="de" value="{{ old('de') }}" required autofocus>
                                        <label class="form-label">Limite Mínimo De*</label>
                                        @if ($errors->has('de'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('de') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('ate') ? ' has-error' : '' }} form-float">
                                    <div class="form-line">
                                        <input id="ate" type="text" class="form-control" name="ate" value="{{ old('ate') }}" required autofocus>
                                        <label class="form-label">Limite Máximo de Até*</label>
                                        @if ($errors->has('ate'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ate') }}</strong>
                                        </span>
                                        @endif
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

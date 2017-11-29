@extends('layouts.app')

@section('content-login')

<div class="login-box">
    <div class="logo" style="margin-left: 25%; margin-top: 180px; margin-bottom: 50px" >
        <img src="{{url('images/logo.svg')}}" alt="Logo" style="width: 70%" />
        <!-- <a href="javascript:void(0);">Mosello<b>LIMA</b></a>
            <small>Sistema de Reembolso</small> -->
        </div>
        <div class="card">
            <div class="body" style="
            padding: 30px; 
            border-bottom-width: 3px;
            border-bottom-color: #FF9800;
            border-bottom-style: solid">
            <form class="form-horizontal" id="sign_in" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="msg">Iniciar Sessão</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail" required autofocus>
                    </div>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Senha" required>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="rememberme" class="filled-in chk-col-orange">
                        <label for="rememberme">Lembrar</label>
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-orange waves-effect" type="submit">ENTRAR</button>
                    </div>
                </div>
                <div class="row m-t-15 m-b--20">
                <!-- <div class="col-xs-6">
                    <a href="sign-up.html">Register Now!</a>
                </div> -->
                <div class="col-md-offset-6 col-md-6 align-right">
                    <a style="color: black" href="{{ route('password.request') }}">Esqueceu a senha?</a>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

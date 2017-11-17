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
            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <!-- <label for="email" class="col-md-4 control-label">E-Mail</label> -->
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <div class="form-line">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail" required autofocus>
                            </div>
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Enviar Link de Recuperação
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

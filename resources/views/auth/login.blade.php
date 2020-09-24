@extends('layouts.app')

@section('content')
    <div class="login-form">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2 class="text-center">Iniciar sesión</h2>		

        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Correo Electrónico">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Contraseña">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline rememberMe"><input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> No cerrar sesión</label>
        </div>         
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block login-btn">ENTRAR</button>
        </div> 
        <div class="clearfix">
            <div class="text-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="pull-right text-success">¿Olvidaste tu contraseña?</a>
            @endif
            </div>
        </div> 
        
    </form>
    <div class="hint-text small">¿Necesitas una cuenta? <a href="{{ route('register') }}" class="text-success">Regístrate</a></div>
</div>
@endsection
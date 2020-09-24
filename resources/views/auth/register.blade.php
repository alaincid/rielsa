@extends('layouts.app')

@section('content')
    <div class="login-form">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="text-center">Regístrate</h2>	

        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"></span>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Usuario">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
        </div>

        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Correo Electrónico">
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
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Contraseña">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Confirmar Contraseña">
            </div>
        </div>

     
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block login-btn">CREAR CUENTA</button>
        </div> 
        
        
    </form>
    <div class="hint-text small">¿Ya tienes una cuenta? <a href="/" class="text-success">Inicia Sesión</a></div>
</div>
@endsection
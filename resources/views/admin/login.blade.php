@extends('layout.app_login')

@section('content')
@include('includes.status')
<div class="login-admin">
    <form method="POST" action="{{route('login')}}" class="form-signin">
        @csrf
        <div class="form-label-group">
            <label for="email">{{ __('Email') }}:</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-label-group mt-4">
            <label for="password">{{ __('Contraseña') }}:</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="btn-checkbox my-4 text-center"><label><input type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>Recuerdame</label></div>

        <div class="button-save-user mt-5 text-center">
            <button style="width: 200px; background-color: lightseagreen; border: none;" class="btn btn-md btn-primary btn-save" type="submit">
                Entrar
            </button>
        </div>
    </form>
</div>
@endsection
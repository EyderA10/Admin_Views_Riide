@extends('layouts.app')

@section('content')
<div class="menu-icon-user">
    <div class="float-left ml-4">
        <span class="icono-user-span"><i class="fas fa-user"></i>Usuarios</span>
    </div>
    <div class="float-right">
        <img class="img-user" src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/modern-bakery-logo-design-template-e979c6db88d6772062e4090687c00b7e_screen.jpg?ts=1602149907" alt="logo-user">
        <i class="fas fa-angle-down"></i>
    </div>
</div>

<div class="container register">
    <form method="POST" action="" class="form-signin">
        @csrf
        <div class="form-label-group">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name">

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <label for="name">{{ __('Name') }}</label>
        </div>


        <div class="form-label-group">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required autocomplete="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <label for="email">{{ __('E-Mail Address') }}</label>
        </div>

        <div class="form-label-group">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Password" required>

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <label for="password">{{ __('Password') }}</label>
        </div>

        <div class="form-label-group">
            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" required>

            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <label for="password">{{ __('Image') }}</label>
        </div>

        <button class="btn btn-sm color-secondary" type="submit">
            <i class="far fa-save"></i> Guardar
        </button>
    </form>
</div>

@endsection
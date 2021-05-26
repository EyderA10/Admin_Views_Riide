@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'sub', 'icon'))
<div class="container register w-50">
    @include('includes.status')
    <form method="POST" action="{{ route('user.newr') }}" class="form-signin" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col form-label-group">
                <label for="name">{{ __('Name') }}:</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col form-label-group">
                <label for="email">{{ __('Correo Electronico') }}:</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col form-label-group">
                <label for="password">{{ __('Contraseña') }}:</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col form-label-group">
                <label for="rol">Rol:</label>
                <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id" autocomplete="rol">>
                @if (Auth::user()->roles->id === 2)
                    @foreach ($roles as $rol)
                    @if ($rol->id !== 2)
                    <option value="{{$rol->id}}">{{$rol->display_name}}</option>
                    @endif
                    @endforeach
                @else
                    @foreach ($roles as $rol)
                    @if ($rol->id === 3)
                    <option value="{{$rol->id}}">{{$rol->display_name}}</option>
                    @endif
                    @endforeach
                 @endif
                </select>
                @error('role_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-label-group my-3 text-center">
            <label for="avatar">{{ __('Imagen') }}:</label>
            <span><i class="fas fa-edit" style="cursor: pointer; color: #2fcece" onclick="handleUploadFile()"></i></span>
            <div id="insert-image"></div>
            <input style="display: none;" onchange="handleChange(this)" type="file" id="avatar" name="avatar" class="form-control @error('image') is-invalid @enderror">
            @error('avatar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="button-save-user text-center">
            <button style="    width: 150px;
    background-color: #2fcece;
    border: none;" class="btn btn-md btn-save text-white" type="submit">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

@endsection
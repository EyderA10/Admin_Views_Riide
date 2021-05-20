@extends('layout.app')

@section('content')
@if (!empty($user) || isset($user))
@include('includes.navbar', compact('name', 'sub', 'icon'))
<div class="container register w-50">
    @include('includes.status')
    <form method="POST" action="{{route('edit.asoc', ['id' => $user->id])}}" class="form-signin" enctype="multipart/form-data">
        @csrf
        <div class="form-label-group">
            <label for="name">{{ __('Name') }}:</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autocomplete="name">

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-label-group">
            <label for="email">{{ __('Correo Electronico') }}:</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" autocomplete="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-label-group">
            <label for="rol">Rol:</label>
            <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id" autocomplete="rol">>
                <option value="{{$user->roles->id}}">{{$user->roles->display_name}}</option>
            </select>

            @error('role_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-label-group text-center mx-auto">
            <label for="avatar">{{ __('Imagen') }}:</label>
            <span><i class="fas fa-edit" style="cursor: pointer; color: #2fcece" onclick="handleUploadFile()"></i></span>
            @if ($user->avatar)
            <div id="update-image">
                <div id="up-avatar" class="mx-auto" style="width: 200px; height: 150px;">
                    <img src="{{ route('my.image', ['image' => $user->avatar]) }}" alt='file-selected' width="100%" height="100%" />
                </div>
            </div>
            @endif
            <input style="display: none;" onchange="handleChange(this)" type="file" id="avatar" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
            @error('avatar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="button-save-user text-center">
            <button style="background-color: #2fcece" class="btn btn-md btn-save text-white" type="submit">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    function handleUploadFile() {
        document.querySelector('#avatar').click();
    }

    function handleChange(e) {
        // console.log(e.files);
        let reader = new FileReader();
        const fileName = e.files[0];
        reader.readAsDataURL(fileName);
        reader.onload = function() {
            const divP = document.querySelector('#update-image');
            let divLast = document.querySelector('#up-avatar');
            let newDiv = document.createElement('div');
            newDiv.style.width = '200px';
            newDiv.style.height = '150px';
            newDiv.className = 'd-flex mx-auto';
            newDiv.innerHTML = `
            <img src="${reader.result}" alt='file-selected' width="100%" height="100%"/>
            <i id="delete-file" class="fas fa-times text-danger ml-2" style="font-size: 20px;"></i>
        `;
            divP.replaceChild(newDiv, divLast);
            if (reader.result) {
                document.getElementById('delete-file').style.cursor = 'pointer';
                document.getElementById('delete-file').onclick = (e) => {
                    document.getElementById('avatar').value = "";
                    divP.replaceChild(divLast, newDiv);
                }
            }
        }
    }
</script>
@endif

@endsection
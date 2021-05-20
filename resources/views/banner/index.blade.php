@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'icon'))
<div class="container">
    <form action="" method="POST" class="form-signin" enctype="multipart/form-data">
        <div class="form-label-group">
            <label for="image">{{ __('Banner') }}:</label>
            <span><i class="fas fa-edit" style="cursor: pointer; color: #2fcece" onclick="handleUploadFile()"></i></span>
            <div id="insert-image"></div>
            <input style="display: none;" onchange="handleChange(this)" type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="d-flex justify-content-between mt-3">
            <div class="form-label-group" style="width: 450px;">
                <label for="titulo">{{ __('Titulo') }}:</label>
                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ old('titulo') }}">
                @error('titulo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-label-group" style="width: 450px;">
                <label for="enlace">{{ __('Enlace') }}:</label>
                <input id="enlace" type="text" class="form-control @error('enlace') is-invalid @enderror" name="enlace" value="{{ old('enlace') }}">
                @error('enlace')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="container mt-5">
        <p class="text-secondary text-center" style="font-size: 16px;">Ubicacion:</p>
            <div class="d-flex" style="justify-content: space-evenly;">
                <button class="btn btn-md" style="background-color: #2fcece; color: white;">Lo mas hot</button>
                <button class="btn btn-md" style="background-color: #2fcece; color: white;">Promociones</button>
                <button class="btn btn-md" style="background-color: #2fcece; color: white;">Categorias(general)</button>
                <button class="btn btn-md" style="background-color: #2fcece; color: white;">Categorias especificas</button>
            </div>
        </div>
        <div class="button-save-user text-center pt-5" style="padding-bottom: 80px;">
            <button style="width: 150px; background-color: #2fcece; border: none;" class="btn btn-md btn-save text-white mb-2" type="submit">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>
<script>
    function handleUploadFile() {
        document.querySelector('#image').click();
    }

    const divP = document.querySelector('#insert-image');
    let newDiv = document.createElement('div');
    newDiv.style.width = '100%';
    newDiv.style.height = '250px';
    newDiv.style.backgroundColor = 'white';
    newDiv.className = 'd-flex align-items-center';
    newDiv.id = 'div-icon-image';
    newDiv.innerHTML = `
    <div style="margin: 0 auto;">
        <i class="far fa-image" style="font-size: 60px; color: gray;"></i>
    </div>
`
    divP.append(newDiv);

    function handleChange(e) {
        // console.log(e.files);
        let reader = new FileReader();
        const fileName = e.files[0];
        reader.readAsDataURL(fileName);
        reader.onload = function() {
            const divP = document.querySelector('#insert-image');
            let divLast = document.querySelector('#div-icon-image');
            let newDiv = document.createElement('div');
            newDiv.style.width = '100%';
            newDiv.style.height = '250px';
            newDiv.className = 'd-flex';
            newDiv.innerHTML = `
            <img src="${reader.result}" alt='file-selected' width="100%" height="100%"/>
            <i id="delete-file" class="fas fa-times text-danger ml-2" style="font-size: 20px;"></i>
        `;
            divP.replaceChild(newDiv, divLast);
            if (reader.result) {
                document.getElementById('delete-file').style.cursor = 'pointer';
                document.getElementById('delete-file').onclick = (e) => {
                    document.getElementById('image').value = "";
                    divP.replaceChild(divLast, newDiv);
                }
            }
        }
    }
</script>
@endsection
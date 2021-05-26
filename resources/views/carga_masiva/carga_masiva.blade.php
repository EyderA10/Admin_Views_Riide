@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'icon'))
    <div class="container mx-auto w-50 text-center">
        <form id="form" action="{{route('import.file')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="d-flex justify-content-around text-center align-content-center">
                <p style="background-color: #2fcece; color:white; border-radius: 100px; width: 38px; height: 38px; font-size: 25px;">1</p>
                <p class="text-secondary mx-auto" style="font-size: 18px;">Descarga el documento</p>
            </div>
            <div class="text-center">
                <a href="{{route('download.excel')}}" class="btn btn-md text-white" style=" width: 150px;
                    background-color: #2fcece;
                    border: none;"><i class="fas fa-cloud-upload-alt mr-2"></i>Descargar</a>
            </div>
            <div class="my-3 d-flex justify-content-around text-center align-content-center">
                <p style="background-color: #2fcece; color:white; border-radius: 100px; width: 38px; height: 38px; font-size: 25px;">2</p>
                <p class="text-secondary mx-auto" style="font-size: 18px;">Llena todos los datos</p>
            </div>
            <div class="d-flex justify-content-around text-center align-content-center">
                <p style="background-color: #2fcece; color:white; border-radius: 100px; width: 38px; height: 38px; font-size: 25px;">3</p>
                <p class="text-secondary mx-auto" style="font-size: 18px;">Sube el documento Aqui</p>
            </div>
            <input type="file" name="carga_masiva_productos" class="form-control w-50 mx-auto mb-4">
            <div class="d-flex justify-content-around text-center align-content-center">
                <p style="background-color: #2fcece; color:white; border-radius: 100px; width: 38px; height: 38px; font-size: 25px;">4</p>
                <p class="text-secondary mx-auto" style="font-size: 18px;">Agrega las imagenes Aqui</p>
            </div>
            <input type="file" name="imagen[]" id="imagen" multiple class="form-control w-50 mx-auto mb-4">
            <div class="mt-1 d-flex justify-content-around text-center align-content-center">
                <p style="background-color: #2fcece; color:white; border-radius: 100px; width: 38px; height: 38px; font-size: 25px;">5</p>
                <p class="text-secondary mx-auto" style="font-size: 18px;">Y listo!<br> solo debes dar click en Guardar</p>
            </div>
            <div class=" text-center">
            <button style="    width: 150px;
    background-color: #2fcece;
    border: none;" class="btn btn-md btn-save text-white" type="submit">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
        </form>
    </div>
@endsection
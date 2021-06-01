@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'icon', 'sub'))
@php
    $producto_imagenes = $producto;
    $producto = $producto[0]->producto;
@endphp
<div class="container" style="margin-top: -25px;">
    <form id="form" action="{{route('update.producto', ['id' => $producto->id])}}" method="POST" class="form-signin" enctype="multipart/form-data">
    <input type="hidden" @if($riide) disabled @endif id="adicionales" name="adicionales" value="">
        <div class="d-flex justify-content-around">
            <div>
                @csrf
                <div class="form-label-group my-3">
                    <label for="producto">{{ __('Titulo') }}:</label>
                    <input id="producto" @if($riide) disabled @endif type="text" class="form-control @error('producto') is-invalid @enderror" name="producto" value="{{$producto->producto}}" placeholder="Nombre del Producto" autocomplete="titulo">
                    @error('producto')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-label-group my-3">
                    <label for="descripcion">{{ __('Descripcion') }}:</label>
                    <textarea id="descripcion" @if($riide) disabled @endif class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{$producto->descripcion}}" placeholder="Escribe Aqui.." autocomplete="descripcion">{{$producto->descripcion}}</textarea>
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row my-3">
                    <div class="col form-label-group">
                        <label for="precio_a">{{ __('Precio 1') }}:</label>
                        <input id="precio_a" @if($riide) disabled @endif type="number" class="form-control @error('precio_a') is-invalid @enderror" placeholder="Precio en dolares" name="precio_a" value="{{ $producto->precio_a }}">
                        @error('precio_a')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col form-label-group">
                        <label for="precio_b">{{ __('Precio 2') }} (promoción):</label>
                        <input id="precio_b" @if($riide) disabled @endif type="number" class="form-control @error('precio_b') is-invalid @enderror" placeholder="Precio en dolares" name="precio_b" value="{{ $producto->precio_b }}">
                        @error('precio_b')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @if (Auth::user()->roles->id === 2)
                    <div class="d-flex justify-content-center my-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1"  name="state" value="1" class="custom-control-input" @if($producto->state === 1) checked @endif>
                            <label class="custom-control-label" for="customRadio1">Activo</label>
                        </div>
                        <div class="custom-control custom-radio ml-4">
                            <input type="radio" id="customRadio2" name="state" value="0" class="custom-control-input" @if($producto->state === 0) checked @endif>
                            <label class="custom-control-label" for="customRadio2">Inactivo</label>
                        </div>
                    </div>
                @endif
                <p class="text-secondary mt-4">Existencia:</p>
                @if (count($tiendas) === 0)
                    <p>Nota: Debe agregar tiendas para poder agregar <br> inventario a los productos</p>
                @endif
                            <div style="height: 200px; overflow: auto;">
                @foreach ($tiendas as $tienda)
                    @if (Auth::user()->roles->id === 7 || Auth::user()->roles->id === 2)
                    <input type="hidden" @if($riide) disabled @endif name="tienda_id[]" value="{{$tienda->id}}">
                    @foreach ($product_quantity as $pd)
                    @if ($pd->tienda_id === $tienda->id)
                                <p class="text-secondary font-weight-bold">Tienda: {{$tienda->tienda}}</p>
                                <div class="d-flex align-items-center mb-4">
                                        <div class="form-check mr-3">
                                            <input @if($riide) disabled @endif class="form-check-input" type="checkbox" name="inventariable[]" id="{{$tienda->id}}" value="1" @if($pd->inventariable === "1") checked @endif>
                                            <label class="form-check-label" for="{{$tienda->id}}">
                                                Por Inventario
                                            </label>
                                        </div>
                                        <div class="col form-label-group">
                                            <label for="cantidad{{$tienda->id}}" style="font-size: 12px;">{{ __('Cantidad') }}:</label>
                                            <input @if($riide) disabled @endif id="cantidad{{$tienda->id}}" style="height: 28px;" type="number" class="col-3 text-center form-control" name="cantidad[]" value="{{$pd->cantidad}}">
                                        </div>
                                
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="form-check">
                                            <input @if($riide) disabled @endif class="form-check-input" type="checkbox" name="inventariable[]" id="{{$tienda->id}}" value="0" @if($pd->inventariable === "0") checked @endif>
                                            <label class="form-check-label" for="{{$tienda->id}}">
                                                Por estatus
                                            </label>
                                        </div>
                                        <div class="ml-5"><input @if($riide) disabled @endif type="checkbox" checked data-toggle="toggle" data-on="Si hay" data-off="No hay"></div>
                                        <script>
                                            $(document).ready(function () {
                                                $('#toggle-switch').bootstrapToggle({
                                                    on: 'si hay',
                                                    off: 'no hay'
                                                });
                                            });
                                        </script>
                                    </div>
                        @endif
                        @endforeach
                        @else
                        <input type="hidden" name="tienda_id[]" value="{{$tienda->tienda->id}}">
                        @foreach ($product_quantity as $pd)
                        @if ($pd->tienda_id === $tienda->tienda->id)
                        <p class="text-secondary font-weight-bold">Tienda: {{$tienda->tienda->tienda}}</p>
                        <div class="d-flex align-items-center mb-4">
                            <div class="form-check mr-3">
                                <input class="form-check-input" type="checkbox" name="inventariable[]" id="{{$tienda->id}}" value="1" @if($pd->inventariable === "1") checked @endif>
                                <label class="form-check-label" for="{{$tienda->tienda->id}}">
                                    Por Inventario
                                </label>
                            </div>
                            <div class="col form-label-group">
                                <label for="cantidad" style="font-size: 12px;">{{ __('Cantidad') }}:</label>
                                <input id="cantidad" style="height: 28px;" type="number" class="col-3 text-center form-control" name="cantidad[]" value="{{$pd->cantidad}}">
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="inventariable[]" value="0" @if($pd->inventariable === "0") checked @endif>
                                <label class="form-check-label" for="{{$tienda->tienda->id}}">
                                    Por estatus
                                </label>
                            </div>
                            <div class="ml-5"><input type="checkbox" checked data-toggle="toggle" data-on="Si hay" data-off="No hay"></div>
                            <script>
                            $(document).ready(function () {
                                $('#toggle-switch').bootstrapToggle({
                                    on: 'si hay',
                                    off: 'no hay'
                                });
                            });
                            </script>
                        </div>
                        @endif
                        @endforeach
                        @endif
                @endforeach
                </div>
            </div>
            <div class="form-label-group my-3">
                <label for="imagen">{{ __('Imagen') }}:</label>
                <span><i class="fas fa-edit" style="cursor: pointer; color: #2fcece" onclick="handleUploadFile()"></i></span>
                <div id="insert-image"></div>
                <input @if($riide) disabled @endif style="display: none;" onchange="handleChangeMultiple(this)" type="file" id="image" name="imagen[]" multiple class="form-control @error('imagen') is-invalid @enderror">
                @error('imagen')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <p class="text-secondary mt-3 mb-0">Elige tu Categoria:</p>
                <!---Categorias-->
                <div class="d-flex flex-column m-0 p-0" id="categorias"></div>

                 <!-- Adicionales -->
                 <div style="border-top: 1px solid lightgray;" class="mt-3">
                     <label class="control-label my-1">Adicionales:</label>
                        <div id="content-adicionales" class="form-group mx-0 px-0">
                        </div>
                 </div>
                <!-- Adicionales -->
            </div>
        </div>
        <div class="button-save-user text-center pb-5 mb-5">
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

    $(document).ready(function () {
        producto = {!! $producto_imagenes !!};
        if(producto[0].imagen) {
            $('#insert-image').css('width', '350px');
            $('#insert-image').append(`
                <div id="carouselExampleControls" class="carousel slide w-100 h-100" data-ride="carousel">
                    <div id="insert-imagen-two" class="carousel-inner">
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            `);
            for (let i = 0; i < producto.length; i++) {
                $("#insert-imagen-two").append(`
                    <div class="carousel-item ${i === 0 ? 'active' : ''}">
                        <img src="/admin/image-prod/${producto[i].imagen}" class="d-block w-100" height="200px" alt="imagen_producto${i}">
                        <div class="w-100" style="text-align: right;">
                            <i id="delete-imagen" onclick="handleDeleteImagen(${producto[i].id})" class="fas fa-times text-danger" style="font-size: 20px;"></i>
                            <i id="edita-imagen" onclick="document.querySelector('#new_image${producto[i].id}').click()" class="fas fa-pen-square text-primary ml-2" style="font-size: 20px;"></i>
                            <input type="file" onchange="handleChange(${ producto[i].id })" name="new_image${producto[i].id}" id="new_image${producto[i].id}" style="display: none;"/>
                        </div>
                    </div>
                `);
            }
        }else {
            const divP = document.querySelector('#insert-image');
            let newDiv = document.createElement('div');
            newDiv.style.width = '250px';
            newDiv.style.height = '180px';
            newDiv.style.backgroundColor = 'white';
            newDiv.className = 'd-flex align-items-center';
            newDiv.id = 'div-icon-image';
            newDiv.innerHTML = `
            <div style="width: 30%;  margin: 0 auto">
                <i class="far fa-image" style="font-size: 60px; color: gray;"></i>
            </div>
        `
            divP.append(newDiv);
        }
        $('.carousel').carousel({
            interval: false
        });
    });

    function handleChange(id) {
        let url = "http://localhost:8000/admin";
        $("#form").attr("action", `${url}/editar-prod-img/${id}`);
        $("#form").submit();
    }

    function handleDeleteImagen(id) {
        let url = "http://localhost:8000/admin";
        $("#form").attr("action", `${url}/eliminar-prod-img/${id}`);
        $("#form").submit();
    }

    function handleChangeMultiple(e) {
        console.log(e);
        $('#insert-image').empty();
        $('#insert-image').css('width', '350px');
        $('#insert-image').append(`
        <div class="w-100" style="text-align: right;">
            <i id="delete-carrousel" class="fas fa-times text-danger" style="font-size: 20px;"></i>
        </div>
            <div id="carouselExampleControls" class="carousel slide w-100 h-100" data-ride="carousel">
                <div id="insert-imagen-two" class="carousel-inner">
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        `);
        for (let i = 0; i < e.files.length; i++) {
            let reader = new FileReader();
            const file = e.files[i];
            reader.onload = function() {
                $("#insert-imagen-two").append(`
                <div class="carousel-item ${i === 0 ? 'active' : ''}">
                    <img src="${reader.result}" class="d-block w-100" height="200px" alt="imagen_producto${i}">
                </div>
                `);
            }
            reader.readAsDataURL(file);
        }
            if($("#delete-carrousel")) {
            $("#delete-carrousel").on('click', function () {
                $('#insert-image').empty();
                $('#insert-image').css('width', '350px');
                if(producto[0].imagen){
                    $('#insert-image').append(`
                        <div id="carouselExampleControls" class="carousel slide w-100 h-100" data-ride="carousel">
                            <div id="insert-imagen-two" class="carousel-inner">
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    `);
                    for (let i = 0; i < producto.length; i++) {
                        $("#insert-imagen-two").append(`
                            <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                <img src="/admin/image-prod/${producto[i].imagen}" class="d-block w-100" height="200px" alt="imagen_producto${i}">
                                <div class="w-100" style="text-align: right;">
                                    <i id="delete-imagen" class="fas fa-times text-danger" style="font-size: 20px;"></i>
                                    <i id="edita-imagen" onclick="document.querySelector('#new_image${producto[i].id}').click()" class="fas fa-pen-square text-primary ml-2" style="font-size: 20px;"></i>
                                    <input type="file" onchange="handleChange(${ producto[i].id })" name="new_image${producto[i].id}" id="new_image${producto[i].id}" style="display: none;"/>
                                </div>
                            </div>
                        `);
                    }
                }else {
                    const divP = document.querySelector('#insert-image');
                    let newDiv = document.createElement('div');
                    newDiv.style.width = '250px';
                    newDiv.style.height = '180px';
                    newDiv.style.backgroundColor = 'white';
                    newDiv.className = 'd-flex align-items-center';
                    newDiv.id = 'div-icon-image';
                    newDiv.innerHTML = `
                    <div style="width: 30%;  margin: 0 auto">
                        <i class="far fa-image" style="font-size: 60px; color: gray;"></i>
                    </div>
                `
                    divP.append(newDiv);
                }
            });
        }
    }
</script>
<script>
    $(document).ready(function() {
        categorias = {!! $categories !!};
        // console.log(categorias);
        for ($i = 0; $i < categorias.length; $i++) {
            // console.log(categorias[$i].parent_id);
            if (categorias[$i].categoria_id == null) {
                $("#categorias").append(`
                    <div id="contain-categories" style="margin-bottom: -23px;">
                        <ul class="list-group">
                        <li class="list-group-item border-0 m-0 p-0 pl-3" data-parent="null" style="background-color: transparent;">
                            <div style="position:unset" class="custom-control form-control-lg custom-checkbox" style="line-height: 1.2;">  
                                <input @if($riide) disabled @endif name="categoria_id[]" value="${categorias[$i].id}" onChange="checkCategoria(this)" type="checkbox" class="custom-control-input" data-id="${categorias[$i].id}" id="categoria${categorias[$i].id}">  
                                <label style="color: #2fcece; font-size: 14px;" id="label-${categorias[$i].id}" class="custom-control-label" for="categoria${categorias[$i].id}">${categorias[$i].categoria}</label>  
                            </div>
                            <ul class="list-group" id="lista-categoria${categorias[$i].id}"></ul>
                        </li>
                    </ul>
                    </div>
                    `);
            }
        }
    });

    function checkCategoria(e) {
            for ($i = 0; $i < categorias.length; $i++) {
                if (categorias[$i].categoria_id == parseInt($(e).attr("data-id"))) {

                    if (e.checked) {
                        $(`#label-${$(e).attr("data-id")}`).addClass("font-weight-bold")
                        // alert(`#lista-categoria${categorias[i].parent_id}`);
                        $(`#lista-categoria${categorias[$i].categoria_id}`).append(`
                            <li class="list-group-item border-0 m-0 p-0 pl-3" data-parent="null" style="background-color: transparent;">
                            <div style="position:unset" class="custom-control form-control-lg custom-checkbox my-0 py-0" style="line-height: 1.2;">  
                                <input @if($riide) disabled @endif name="categoria_id[]" value="${categorias[$i].id}" onChange="checkCategoria(this)" type="checkbox" class="custom-control-input" data-id="${categorias[$i].id}" id="categoria${categorias[$i].id}">  
                                <label class="custom-control-label" id="label-${categorias[$i].id}" style="font-size: 14px;" for="categoria${categorias[$i].id}">${categorias[$i].categoria}</label>  
                            </div>
                            <ul class="list-group" id="lista-categoria${categorias[$i].id}"></ul>
                        </li>
                            `);
                        /*$(`#lista-categoria${categorias[i].parent_id}`).append(`
                        <li style="list-style:none;" data-parent="null" >
                            <div class="form-check">
                                <input name="categorias[]" value="${categorias[i].id}" name="categorias[]" onChange="checkCategoria(this)" type="checkbox" class="form-check-input custom-control-input check-categoria" data-id="${categorias[i].id}" id="categoria${categorias[i].id}">
                                <label class="form-check-label custom-control-label" for="categoria${categorias[i].id}">${categorias[i].name}</label>
                            </div>
                            <ul id="lista-categoria${categorias[i].id}"></ul>
                        </li>
                        `);*/
                    } else {
                        // if(categorias[$i].categoria_id != null){
                        $(`#label-${$(e).attr("data-id")}`).removeClass("font-weight-bold");
                        // }

                        $(`#lista-categoria${categorias[$i].categoria_id}`).empty();
                    }


                }
            }
        }
</script>

<script>
$(document).ready(function () {
    adicionales = {!! $adicionales !!};
        $("#content-adicionales").html("");
        if( adicionales.length > 0) {
                for(let i = 0; i < adicionales.length ; i++){
                cont_add = window.crypto.getRandomValues(new Uint32Array(1))[0];
                cont_add.toString(16);
                cont_add = cont_add.toString(16);
                console.log(cont_add);

                $("#content-adicionales").append(`
                    <div class='row mx-0 px-0' id="cont-add-${cont_add}">
                            <div class='form-group px-0'>
                                <label class='control-label'>Adicional</label>
                                <input @if($riide) disabled @endif data-type="adicional" data-id="${cont_add}" value="${adicionales[i].adicional}" id="adicional-${cont_add}" name="adicional-${cont_add}" type='text' class='form-control'>
                            </div>
                            <div class='form-group px-0 ml-3'>
                                <label class='control-label'>Precio por unidad</label>
                                <input @if($riide) disabled @endif type='number' data-id="${cont_add}" id="precio-${cont_add}" value="${adicionales[i].precio}" name="precio-${cont_add}" class='form-control'>
                            </div>
                            <div class='form-group px-0 ml-3' style="margin-top: 8px;">
                                    <br>
                                <button @if($riide) disabled @endif data-id="${cont_add}" onClick="removeAdicional(event)" type='button' class='btn btn-danger removeAdicional'>
                                    -
                                </button>
                                <button @if($riide) disabled @endif data-id="${cont_add}" onClick="addAdicional(event)" type='button' class='btn btn-primary addAdicional'>
                                    +
                                </button>
                            </div>
                        </div>
                `);
            }
        } else {
            cont_add = window.crypto.getRandomValues(new Uint32Array(1))[0];
            cont_add.toString(16);
            cont_add = cont_add.toString(16);
            console.log(cont_add);

            $("#content-adicionales").append(`
            <div class='row mx-0 px-0' id="cont-add-${cont_add}">
                        <div class='form-group px-0'>
                            <label class='control-label'>Adicional</label>
                            <input data-type="adicional" data-id="${cont_add}" value="" id="adicional-${cont_add}" name="adicional-${cont_add}" type='text' class='form-control'>
                        </div>
                        <div class='form-group px-0 ml-3'>
                            <label class='control-label'>Precio por unidad</label>
                            <input @if($riide) disabled @endif type='number' data-id="${cont_add}" id="precio-${cont_add}" value="" name="precio-${cont_add}" class='form-control'>
                        </div>
                        <div class='form-group px-0 ml-3' style="margin-top: 8px;">
                                <br>
                            <button @if($riide) disabled @endif data-id="${cont_add}" onClick="removeAdicional(event)" type='button' class='btn btn-danger removeAdicional'>
                                -
                            </button>
                            <button @if($riide) disabled @endif data-id="${cont_add}" onClick="addAdicional(event)" type='button' class='btn btn-primary addAdicional'>
                                +
                            </button>
                        </div>
                    </div>
            `);
        }

        $( "#form" ).submit(function( event ) {
                //alert( "Handler for .submit() called." );
                //event.preventDefault();

                let input_add = $("input[data-type=adicional]");
                let adicionales = [];
                for( let i = 0 ; i < input_add.length ; i++ ){
                    console.log( "id = ", input_add[i].dataset.id, "value = " , input_add[i].value , "precio = " , $("#precio-" + input_add[i].dataset.id ).val() )
                    adicionales.push({ adicional : input_add[i].value, precio : $("#precio-" + input_add[i].dataset.id ).val() });
                }
                console.log(adicionales)
                adicionales = JSON.stringify(adicionales);
                $("#adicionales")[0].value = adicionales
                console.log( "input = ", $("#adicionales")[0].value )
                //$( "#form" ).submit();
        });
    });

     //Adicionales
    function removeAdicional(e) {
        console.log(e);
        $("#cont-add-" + e.target.dataset.id ).remove();
    }

    function addAdicional() {
        cont_add = window.crypto.getRandomValues(new Uint32Array(1))[0];
        cont_add =cont_add.toString(16);
        console.log(cont_add)
        $("#content-adicionales").append(`
        <div class='row mx-0 px-0' id="cont-add-${cont_add}">
                <div class='form-group px-0'>
                    <label class='control-label'>Adicional</label>
                    <input data-type="adicional" data-id="${cont_add}" value="" id="adicional-${cont_add}" name="adicional-${cont_add}" type='text' class='form-control'>
                </div>
                <div class='form-group px-0 ml-3'>
                    <label class='control-label'>Precio por unidad</label>
                    <input type='number' data-id="${cont_add}" id="precio-${cont_add}" name="precio-${cont_add}" class='form-control'>
                </div>
                <div class='form-group px-0 ml-3' style="margin-top: 8px;">
                        <br>
                    <button data-id="${cont_add}" onClick="removeAdicional(event)" type='button' class='btn btn-danger removeAdicional'>
                        -
                    </button>
                    <button data-id="${cont_add}" onClick="addAdicional()" type='button' class='btn btn-primary addAdicional'>
                        +
                    </button>
                </div>
            </div>
        `);
    }
    //Adicionales
</script>
@endsection
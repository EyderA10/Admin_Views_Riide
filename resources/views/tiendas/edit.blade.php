@extends('layout.app')
@section('content')

@include('includes.navbar', compact('name', 'sub', 'icon'))

<div class="container">
    <form id="form-store" action="{{route('update.store', ['id' => $tienda->id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-between">
            <p style="font-size: 22px; color: #2fcece">Tu marca:</p>
            <i style="color: #2fcece; position: absolute; top: 20%; right: 10%;" onclick="handleUploadFilePanel()" id="hidePenPanel" class="fas fa-pen"></i>
            <input type="file" @if($riide) disabled @endif onchange="handleChangePanel(this)" id="panel" name="panel" style="display: none;" />
            <input type="file" @if($riide) disabled @endif onchange="handleChangeImagen(this)" id="imagen" name="imagen" style="display: none;" />
        </div>
            @if ($tienda->panel !== null)
            <div id="insert-panel" style="width: 100%; height: 250px;">
                <img src="{{route('my.panel', ['panel' => $tienda->panel])}}" alt='file-selected' width="100%" height="100%"/>
            </div>
            @else
            <div id="insert-panel" style="width: 100%; height: 250px;">
                <img src="http://amsolidaritas.com.ar/wp-content/themes/wellington/assets/images/default-slider-image.png" alt='file-selected' width="100%" height="100%"/>
            </div>
            @endif
        <div id="div-inser-img" class="d-flex" style="align-items:flex-end;">
        <i style="color: #2fcece; position: absolute; top: 60%; left: 15%;" onclick="handleUploadFileImagen()" id="hidePenImagen" class="fas fa-pen"></i>
                @if ($tienda->imagen === null)
                    <div id="insert-image" style="width: 9%; height: 93px;">
                        <img src="http://amsolidaritas.com.ar/wp-content/themes/wellington/assets/images/default-slider-image.png" alt='file-selected' width="100%" height="100%"/>
                    </div>
                @else
                    <div id="insert-image" style="width: 9%; height: 93px;">
                        <img src="{{route('my.imagen.tienda', ['imagen' => $tienda->imagen])}}" alt='file-selected' width="100%" height="100%"/>
                    </div>
                @endif
                <div class="ml-2">
                    <i style="color: #2fcece; position: absolute; top: 70%; left: 41%;" id="penTienda" class="fas fa-pen"></i>
                    <input style="width: 22rem;" @if($riide) disabled @endif type="text" class="form-control" name="tienda" value="{{$tienda->tienda}}" placeholder="Nombre de la Marca:">
                    <i style="color: #2fcece; position: absolute; top: 62%; left: 41%;" id="penSector" class="fas fa-pen"></i>
                    <input style="width: 22rem;" @if($riide) disabled @endif type="text" class="form-control mt-2" name="sector" value="{{$tienda->sector}}" placeholder="Sector:">
                </div>
        </div>
        <div class="d-flex justify-content-between mt-2 mb-5" style="height: 70px;">
            <a id="show-cat" href="" style="width: 210px; background-color: #2fcece; font-size: 18px" class="show my-3 btn btn-large d-flex justify-content-center text-white text-decoration-none">Categorias<i id="btn-toggle" style="color: white" class="fas fa-angle-down my-auto ml-2"></i></a>
            <a id="show-map" href="" style="width: 210px; background-color: #2fcece; font-size: 18px" class="show my-3 btn btn-large d-flex justify-content-center text-white text-decoration-none">Ubicacion<i id="btnn-toggle" style="color: white" class="fas fa-angle-down my-auto ml-2"></i></a>
            <div class="row p-0 m-0">
                <div class="col p-0 m-0">
                    <div class="d-flex m-2 p-2" style="background-color: #2fcece; width: 150px; height: 50px; border-radius: 10px;">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-clock ml-2" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                            </svg>
                        </div>
                        <div class="d-flex flex-column ml-2">
                            <div class="w-100 h-100 d-flex text-white">
                                <input type="number" @if($riide) disabled @endif name="tiempo" value="{{$tienda->tiempo}}" placeholder="00" class="border-0 bg-transparent h-100" style="outline: 0px ;font-size: 36px ;width: 53px;">
                                <div class="w-100 h-100 text-white d-flex align-items-center" style="font-size: 18px ;">
                                    min
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="ml-2 mt-2 century" style="color: lightseagreen; font-size: 15px;">Preparacion del pedido</h5>
                </div>
            </div>
        </div>
        <!---Categorias-->
        <div class="row m-0 p-0" id="categorias"></div>
        <!---Mapa-->
        <div id="map-cpm" class="w-75 mx-auto" style="height: 400px ;">
            <div id="map" style="height: 100%;"></div>
        </div>
        <select name="user_id[]" @if($riide) disabled @endif id="multiple-checkboxes" multiple="multiple">
            @foreach ($users as $user)
                @if ($user->roles->name === 'Asociado')
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endif
            @endforeach
        </select>
        @if (Auth::user()->roles->id === 2)
        <div class="d-flex justify-content-center my-4">
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio1"  name="state" value="1" class="custom-control-input" @if($tienda->state === 1) checked @endif>
                <label class="custom-control-label" for="customRadio1">Activo</label>
            </div>
            <div class="custom-control custom-radio ml-4">
                <input type="radio" id="customRadio2" name="state" value="0" class="custom-control-input" @if($tienda->state === 0) checked @endif>
                <label class="custom-control-label" for="customRadio2">Inactivo</label>
            </div>
        </div>
        @endif
        <div class="pt-4 pb-5 text-center">
            <button type="submit" style="width: 180px; background-color: #2fcece; color: white; font-size: 18px;" class="btn btn-md"> <i class="fas fa-save mr-2"></i>Guardar</button>
        </div>
    </form>
<script>
    function handleUploadFilePanel() {
        document.querySelector('#panel').click();
    }

    function handleUploadFileImagen() {
        document.querySelector('#imagen').click();
    }

    function handleChangePanel(e) {
        // console.log(e.files);
        let reader = new FileReader();
        const fileName = e.files[0];
        reader.readAsDataURL(fileName);
        reader.onload = function() {
            $("#hidePenPanel").hide();
            const divP = document.querySelector('#form-store');
            let divLast = document.querySelector('#insert-panel');
            let newDiv = document.createElement('div');
            newDiv.style.width = '100%';
            newDiv.style.height = '250px';
            newDiv.className = 'd-flex';
            newDiv.innerHTML = `
            <img src="${reader.result}" alt='file-selected' width="100%" height="100%"/>
            <i id="delete-file-panel" class="fas fa-times text-danger ml-2" style="font-size: 20px;"></i>
        `;
            divP.replaceChild(newDiv, divLast);
            if (reader.result) {
                document.getElementById('delete-file-panel').style.cursor = 'pointer';
                document.getElementById('delete-file-panel').onclick = (e) => {
                    document.getElementById('panel').value = "";
                    $("#hidePenPanel").show();
                    divP.replaceChild(divLast, newDiv);
                }
            }
        }
    }
    function handleChangeImagen(e) {
        console.log(e.files);
        let reader = new FileReader();
        const fileName = e.files[0];
        reader.readAsDataURL(fileName);
        reader.onload = function() {
            $("#hidePenImagen").hide();
            $("#penTienda").css("left", "43%");
            $("#penSector").css("left", "43%");
            const divP = document.querySelector('#div-inser-img');
            let divLast = document.querySelector('#insert-image');
            let newDiv = document.createElement('div');
            newDiv.style.width = '9%';
            newDiv.style.height = '93px';
            newDiv.className = 'd-flex mx-3';
            newDiv.innerHTML = `
            <img src="${reader.result}" alt='file-selected' width="100%" height="100%"/>
            <i id="delete-file" class="fas fa-times text-danger ml-2" style="font-size: 20px;"></i>
        `;
            divP.replaceChild(newDiv, divLast);
            if (reader.result) {
                document.getElementById('delete-file').style.cursor = 'pointer';
                document.getElementById('delete-file').onclick = (e) => {
                    document.getElementById('imagen').value = "";
                    divP.replaceChild(divLast, newDiv);
                    $("#hidePenImagen").show();
                    $("#penTienda").css("left", "41%");
                    $("#penSector").css("left", "41%");
                }
            }
        }
    }
</script>
    <script>
        $(document).ready(function() {
            //multiselect
                $('#multiple-checkboxes').multiselect({
                    buttonWidth: '200px',
                    includeSelectAllOption: true,
                    nonSelectedText: 'Selecciona un usuario'
                });

            $("#map-cpm").hide();
            $("#show-map").click((e) => {
                e.preventDefault();
                if ($("#show-map").hasClass("show")) {
                    $("#map-cpm").show();
                    $("#btnn-toggle").removeClass("fa-angle-down");
                    $("#btnn-toggle").addClass("fa-angle-up");
                    $("#show-map").removeClass("show");
                } else {
                    $("#map-cpm").hide();
                    $("#show-map").addClass("show");
                    $("#btnn-toggle").removeClass("fa-angle-up");
                    $("#btnn-toggle").addClass("fa-angle-down");
                }
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $("#show-cat").click((e) => {
                e.preventDefault();
                categorias = {!! $categories !!};
                // console.log(categorias);
                if ($("#show-cat").hasClass("show")) {
                    $("#categorias").show();
                    $("#btn-toggle").removeClass("fa-angle-down");
                    $("#btn-toggle").addClass("fa-angle-up");
                    $("#show-cat").removeClass("show");
                    for ($i = 0; $i < categorias.length; $i++) {
                        // console.log(categorias[$i].parent_id);
                        if (categorias[$i].categoria_id == null) {
                            $("#categorias").append(`
                    <div id="contain-categories" class="col-md-3 my-3">
                        <ul class="list-group">
                        <li class="list-group-item border-0 m-0 p-0 pl-3" data-parent="null" style="background-color: transparent;">
                            <div style="position:unset" class="custom-control form-control-lg custom-checkbox" style="line-height: 1.2;">  
                                <input @if($riide) disabled @endif name="categoria_id[]" value="${categorias[$i].id}" onChange="checkCategoria(this)" type="checkbox" class="custom-control-input" data-id="${categorias[$i].id}" id="categoria${categorias[$i].id}">  
                                <label style="color: #2fcece;" id="label-${categorias[$i].id}" class="custom-control-label" for="categoria${categorias[$i].id}">${categorias[$i].categoria}</label>  
                            </div>
                            <ul class="list-group m-0 p-0" id="lista-categoria${categorias[$i].id}"></ul>
                        </li>
                    </ul>
                    </div>
                    `);
                        }
                    }
                } else {
                    $("#categorias").hide();
                    $("#categorias").empty();
                    $("#show-cat").addClass("show");
                    $("#btn-toggle").removeClass("fa-angle-up");
                    $("#btn-toggle").addClass("fa-angle-down");
                }
            });
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
                                <label class="custom-control-label" id="label-${categorias[$i].id}" for="categoria${categorias[$i].id}">${categorias[$i].categoria}</label>  
                            </div>
                            <ul class="list-group m-0 p-0" id="lista-categoria${categorias[$i].id}"></ul>
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
        let map;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: -34.397,
                    lng: 150.644
                },
                zoom: 8,
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNtwjTrvyPZFzE6XbUhSccljXgIUMWdK0&callback=initMap&libraries=&v=weekly" async></script>
</div>
@endsection
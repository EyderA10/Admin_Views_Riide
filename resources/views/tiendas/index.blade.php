@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'icon'))

<div class="container">
    <form id="form-edit-store" action="{{route('edita.tiendas')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-between">
            <p style="font-size: 22px; color: #2fcece">Tu marca:</p>
            <i style="color: #2fcece; position: absolute; top: 20%; right: 10%;" onclick="handleUploadFilePanel()" id="hidePenPanel" class="fas fa-pen"></i>
            <input type="file" id="panel" name="panel" style="display: none;" />
            <input type="file" id="imagen" name="imagen" style="display: none;" />
        </div>
        <div id="insert-panel" class="w-100 text-center d-flex" style="background-color: white; height: 250px;">
            <i class="far fa-image m-auto" style="font-size: 50px; color: gray;"></i>
        </div>
        <div id="div-inser-img" class="d-flex" style="align-items:flex-end;">
            <i style="color: #2fcece; position: absolute; top: 60%; left: 15%;" onclick="handleUploadFileImagen()" id="hidePenImagen" class="fas fa-pen"></i>
            <div id="insert-image" class="text-center d-flex" style="width: 9%; background-color: white; height: 93px; border: 1px solid gray;">
                <i class="far fa-image m-auto" style="font-size: 20px; color: gray;"></i>
            </div>
            <div class="ml-2">
                <i style="color: #2fcece; position: absolute; top: 70%; left: 41%;" id="penSector" class="fas fa-pen"></i>
                <input style="width: 22rem;" type="text" class="form-control" id="tienda" name="tienda" placeholder="Nombre de la Marca:">
                <i style="color: #2fcece; position: absolute; top: 62%; left: 41%;" id="penTienda" class="fas fa-pen"></i>
                <input style="width: 22rem;" type="text" class="form-control mt-2" id="sector" name="sector" placeholder="Sector:">
            </div>
        </div>
    </form>
    @if (Auth::user()->roles->id === 7)
    <div class="d-flex justify-content-end">
        <a href="{{route('create.tienda')}}" style="    width: 150px;
        background-color: #2fcece;
        border: none;" class="btn btn-md text-decoration-none text-white"><i class="fas fa-plus-square text-white mr-2"></i>Crear Tienda</a>
    </div>
    @endif
    <p style="font-size: 22px; color: #2fcece" class="mt-2">Tus Tiendas:</p>
    @if (count($tiendas) === 0)
    <div class="text-center d-flex mx-auto" style="background-color: white; width: 250px; height: 250px; border-radius: 10px; margin-bottom: 50px;">
        <div class="m-auto">
            <i class="fa fa-store" style="font-size: 50px; color: gray;"></i>
            <a href="{{route('create.tienda')}}" style="color: gray" class="text-decoration-none d-block mt-2">Crear Tienda</a>
        </div>
    </div>
    @endif
    <div class="row mt-4 mb-4 p-3">
        <div class="col m-0 p-0">
            <div class="swiper-container" style="position:unset;">
                <div class="swiper-wrapper">
                    @foreach ($tiendas as $tienda)
                    <div class="swiper-slide d-flex align-items-end">
                        <div class="w-100 d-flex">
                            <div class="w-100 d-flex">
                                <div class="card" style="width: 18rem;">
                                    @if ($tienda->panel !== null || $tienda->tienda->panel !== null)
                                        @if (Auth::user()->roles->id === 7)
                                        <img src="{{route('my.panel', ['panel' => $tienda->panel])}}" height="250px" class="card-img-top p-2" alt="user-image">
                                        @else
                                        <img src="{{route('my.panel', ['panel' => $tienda->tienda->panel])}}" height="250px" class="card-img-top p-2" alt="user-image">
                                        @endif
                                    @else
                                        <img src="http://amsolidaritas.com.ar/wp-content/themes/wellington/assets/images/default-slider-image.png" height="250px" class="card-img-top p-2" alt="user-image">
                                    @endif
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between text-center align-items-center">
                                            <div class="mr-2">
                                            @if ($tienda->imagen !== null || !empty($tienda->tienda->imagen))
                                                @if (Auth::user()->roles->id === 7)
                                                    <img style="border-radius: 999px;" width="50px" height="50px" src="{{route('my.imagen.tienda', ['imagen' => $tienda->imagen])}}" alt="">
                                                @else
                                                    <img style="border-radius: 999px;" width="50px" height="50px" src="{{route('my.imagen.tienda', ['imagen' => $tienda->tienda->imagen])}}" alt="">
                                                @endif
                                            @else
                                                <img style="border-radius: 999px;" width="50px" height="50px" src="http://amsolidaritas.com.ar/wp-content/themes/wellington/assets/images/default-slider-image.png" alt="">
                                            @endif
                                            </div>
                                            <div style="width: 130px;">
                                            @if (Auth::user()->roles->id === 7)
                                                <p class="card-title" style="font-size: 20px; margin-bottom: 0;">{{$tienda->tienda}}</p>
                                                <p class="card-text" style="font-size: 14px;">{{$tienda->sector}}</p>
                                            @else
                                                <p class="card-title" style="font-size: 20px; margin-bottom: 0;">{{$tienda->tienda->tienda}}</p>
                                                <p class="card-text" style="font-size: 14px;">{{$tienda->tienda->sector}}</p>
                                            @endif
                                            </div>
                                            @if (Auth::user()->roles->id === 7)
                                            <a href="{{route('tienda.update', ['id' => $tienda->id])}}" class="text-decoration-none ml-3" style="color: #2fcece; font-size: 14px;"><i class="fas fa-pen"></i>
                                                <span>Editar</span>
                                            </a>
                                            <a href="{{route('delete.tienda', ['id' => $tienda->id])}}" class="text-decoration-none ml-1" style="color: #2fcece; font-size: 14px;"><i class="fas fa-trash-alt"></i>
                                                <span>Borrar</span>
                                            </a>
                                            @else
                                            <a href="{{route('tienda.update', ['id' => $tienda->tienda->id])}}" class="text-decoration-none ml-3" style="color: #2fcece; font-size: 14px;"><i class="fas fa-pen"></i>
                                                <span>Editar</span>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <!-- <div class="swiper-pagination"></div> -->
            </div>
        </div>
    </div>

    <script>
        function handleUploadFilePanel() {
            document.querySelector('#panel').click();
        }

        function handleUploadFileImagen() {
            document.querySelector('#imagen').click();
        }

        const tiendas = {!! $tiendas !!}
        const user = {!! Auth::user() !!};

        $("#imagen, #panel").on("change", function() {
            $("#form-edit-store").submit();
        });

        $("#penTienda, #penSector").on("click", function() {
            $("#form-edit-store").submit();
        });

        if (tiendas.length !== 0) {
            tiendas.forEach((e) => {
                console.log(e);
                    let divPanel = document.querySelector('#form-edit-store');
                    let divLastPanel = document.querySelector('#insert-panel');
                    let newDivPanel = document.createElement('div');
                    newDivPanel.style.width = '100%';
                    newDivPanel.style.height = '250px';
                    if(e.panel !==  null && e.tienda.panel !== null){
                        newDivPanel.innerHTML = `
                        <img src="/admin/get-panel/${user.roles.id === 3 ? e.tienda.panel : e.panel}" alt='file-selected' width="100%" height="100%"/>
                        <input type="hidden" name="panel_tienda" value="${user.roles.id === 3 ? e.tienda.panel : e.panel}"/>
                        `;
                    }else {
                        newDivPanel.innerHTML = `
                        <img src="http://amsolidaritas.com.ar/wp-content/themes/wellington/assets/images/default-slider-image.png" alt='file-selected' width="100%" height="100%"/>
                        <input type="hidden" name="panel_tienda" value="null"/>
                        `;
                    }
                    divPanel.replaceChild(newDivPanel, divLastPanel);
                
                    const divP = document.querySelector('#div-inser-img');
                    let divLast = document.querySelector('#insert-image');
                    let newDiv = document.createElement('div');
                    newDiv.style.width = '9%';
                    newDiv.style.height = '93px';
                    if(e.imagen !== null && e.tienda.imagen !== null){
                        newDiv.innerHTML = `
                            <img src="/admin/get-imagen/${user.roles.id === 3 ? e.tienda.imagen : e.imagen}" alt='file-selected' width="100%" height="100%"/>
                            <input type="hidden" name="imagen_tienda" value="${user.roles.id === 3 ? e.tienda.imagen : e.imagen}"/>
                        `;
                    }else {
                        newDiv.innerHTML = `
                            <img src="http://amsolidaritas.com.ar/wp-content/themes/wellington/assets/images/default-slider-image.png" alt='file-selected' width="100%" height="100%"/>
                            <input type="hidden" name="imagen_tienda" value="null"/>
                        `;
                    }
                    divP.replaceChild(newDiv, divLast);
                    if(e.tienda || e.tienda.tienda || e.sector || e.tienda.sector){
                        $("#tienda").val(user.roles.id === 3 ? e.tienda.tienda : e.tienda);
                        $("#sector").val(user.roles.id === 3 ? e.tienda.sector : e.sector);
                    }else {
                        $("#tienda").val('');
                        $("#sector").val('');
                    }
            });
        }
    </script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 4,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            pagination: {
                el: '.swiper-pagination',
            },
        });
    </script>
</div>
@endsection
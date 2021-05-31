@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'icon'))
<div class="container d-flex justify-content-around">
    <div class="dropdown">
        <button style="background-color: #2fcece; color: white;" class="btn dropdown-toggle" type="button" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Estado
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
            <a class="dropdown-item" href="{{route('all.tiendas')}}">Todos</a>
            <a class="dropdown-item" href="{{route('state.tiendas', ['state' => 1])}}">Activo</a>
            <a class="dropdown-item" href="{{route('state.tiendas', ['state' => 0])}}">Inactivo</a>
        </div>
    </div>
    <form id="buscador" action="{{route('search.tiendas')}}" method="GET">
        <div class="form-inline">
            <input class="form-control mr-2" name="search" id="search" type="search" placeholder="Buscar" aria-label="Search" style="width: 500px;">
            <button class="btn btn-secondary" type="submit"><i class="fas fa-search text-white"></i></button>
        </div>
    </form>
</div>
<div class="container">
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
                                        <img src="{{route('my.panel', ['panel' => $tienda->panel])}}" height="250px" class="card-img-top p-2" alt="user-image">
                                    @else
                                        <img src="http://amsolidaritas.com.ar/wp-content/themes/wellington/assets/images/default-slider-image.png" height="250px" class="card-img-top p-2" alt="user-image">
                                    @endif
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between text-center align-items-center">
                                            <div class="mr-2">
                                            @if ($tienda->imagen !== null || !empty($tienda->tienda->imagen))
                                                <img style="border-radius: 999px;" width="50px" height="50px" src="{{route('my.imagen.tienda', ['imagen' => $tienda->imagen])}}" alt="">
                                            @else
                                                <img style="border-radius: 999px;" width="50px" height="50px" src="http://amsolidaritas.com.ar/wp-content/themes/wellington/assets/images/default-slider-image.png" alt="">
                                            @endif
                                            </div>
                                            <div style="width: 130px;">
                                                <p class="card-title" style="font-size: 20px; margin-bottom: 0;">{{$tienda->tienda}}</p>
                                                <p class="card-text" style="font-size: 14px;">{{$tienda->sector}}</p>
                                            </div>
                                            <a href="{{route('tienda.update', ['id' => $tienda->id])}}" class="text-decoration-none ml-3" style="color: #2fcece; font-size: 14px;"><i class="far fa-eye"></i>
                                                <span>Ver</span>
                                            </a>
                                            <a href="{{route('horarios', ['tienda_id' => $tienda->id])}}" class="text-decoration-none ml-3" style="color: #2fcece; font-size: 14px;"><i class="fa fa-clock"></i>
                                                <span>Horario</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">{{$tiendas->links('pagination::bootstrap-4')}}</div>
                <!-- Add Pagination -->
                <!-- <div class="swiper-pagination"></div> -->
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#buscador").submit(function(e) {
                // e.preventDefault();
                let url = "http://localhost:8000/admin";
                const valor = $("#buscador #search").val();
                $(this).attr("action", `${url}/tienda-found/${valor}`);
            });
        });
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
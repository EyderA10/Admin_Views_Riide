@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'icon'))
<div class="container">
    <div class="d-flex justify-content-center align-items-center" style="background-color: #2fcece;
    height: 100px;
    border-radius: 0 0 15px 15px;">
        <form>
            <div class="form-inline">
                <button class="btn btn-secondary mr-1" type="submit"><i class="fas fa-search text-white"></i></button>
                <input class="form-control" type="search" placeholder="¿Que estas Buscando?" aria-label="Search" style="width: 501px; height: 42px;">
            </div>
        </form>
        <div class="dropdown ml-2" style="position: absolute; right: 30%">
            <button style="background-color: #2fcece; color: white;" class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Categorias
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
    </div>
    @if (count($productos) === 0)
    <div class="text-center d-flex mx-auto mt-3" style="background-color: white; width: 250px; height: 250px; border-radius: 10px; margin-bottom: 50px;">
        <div class="m-auto">
            <i class="fa fa-shopping-cart" style="font-size: 50px; color: gray;"></i>
            <a href="{{route('create.producto')}}" style="color: gray" class="text-decoration-none d-block mt-2">Crear Producto</a>
        </div>
    </div>
    @endif
    <div class="row my-4 p-3">
        <div class="col m-0 p-0">
            <div class="swiper-container" style="position:unset;">
                <div class="swiper-wrapper">
                    @foreach ($productos as $producto)
                    <div class="swiper-slide d-flex align-items-end">
                        <div class="w-100 d-flex">
                            <div class="w-100 d-flex">
                                <div class="card" style="width: 18rem;">
                                @if ($producto->imagen === null)
                                    <img src="img/1619548072-profile.jpg" height="250px" class="card-img-top p-2" alt="user-image">
                                @else
                                    <img src="{{route('imagen.prod', ['imagen' => $producto->imagen])}}" height="250px" class="card-img-top p-2" alt="user-image">
                                @endif
                                    <div class="card-body" style="padding: 1.10rem; padding-top: 0;">
                                        <p class="card-title text-center" style="font-size: 25px;">{{$producto->producto}}</p>
                                        <div class="d-flex justify-content-around text-center align-items-center">
                                            <a href="{{route('edit.producto', ['id' => $producto->id])}}" class="text-decoration-none ml-3" style="color: #2fcece;"><i style="font-size: 23px;" class="fas fa-pen"></i>
                                                <p class="text-secondary" style="font-size: 14px;">Editar</p>
                                            </a>
                                            @if (Auth::user()->roles->id === 7 || Auth::user()->roles->id === 2)
                                            <a href="{{route('delete.prod', ['id' => $producto->id])}}" class="text-decoration-none ml-1" style="color: #2fcece;"><i style="font-size: 23px;" class="fas fa-trash-alt"></i>
                                                <p class="text-secondary" style="font-size: 14px;">Borrar</p>
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
<div class="d-flex justify-content-center pt-3 pb-5">
    <a href="{{route('create.producto')}}" style="background-color: #2fcece; width: 160px;" class="btn btn-large text-white"><i class="fas fa-plus-square mr-2"></i>Crear producto</a>
    <a href="#" style="background-color: #2fcece; width: 160px;" class="btn btn-large text-white ml-5"><i class="fas fa-trash-alt mr-2"></i>Borrado masivo</a>
</div>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 5,
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
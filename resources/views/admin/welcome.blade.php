@extends('layout.app')

@section('content')
<div class="menu-icon-user mt-3">
    <div class="d-flex">
        <div class="letters-ride-welcome text-center">
            <h1>Bienvenidos a <img src="{{asset('img/LOGO RIIDE PNG.png')}}" alt="wel_riide"></h1>
        </div>
        <div>
            <img class="img-user" src="{{Auth::user()->avatar}}" alt="logo-user">
            <a href="#" style="color: #2fcece" class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                <a href="{{route('logout')}}" class="dropdown-item" type="button" onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">Log out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mx-auto my-3" style="width: 65%; height: 350px;">
    <div id="carouselExampleControls" class="carousel slide w-100" data-ride="carousel" style="height: 100%;">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://pbs.twimg.com/media/De3PM4uWAAAiyOY.jpg:large" class="d-block w-100" height="350px" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://oinkmygod.com/wp-content/uploads/2021/02/que-es-shopify.jpg" class="d-block w-100" height="350px" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-HCaOYY_LDppP_Xo5EJPByDUsiF3RVL3S2pAi7vj1hP7WYgWtGPsnve98yczpcL0iQrk&usqp=CAU" class="d-block w-100" height="350px" alt="...">
            </div>
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
</div>
<div class="mx-auto pt-3 pb-5" style="width: 30%;">
    <img src="{{asset('img/Componente 18 – 1.png')}}" width="100%" alt="letras-riide">
</div>

@endsection
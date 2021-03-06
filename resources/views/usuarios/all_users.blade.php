@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'icon'))
<div class="container d-flex justify-content-between">
    <form>
        <div class="form-inline">
            <input class="form-control mr-2" type="search" placeholder="Buscar" aria-label="Search" style="width: 500px;">
            <button class="btn btn-secondary" type="submit"><i class="fas fa-search text-white"></i></button>
        </div>
    </form>
    <a href="{{ route('user.register') }}" style="    width: 150px;
    background-color: #2fcece;
    border: none;" class="btn btn-md text-decoration-none text-white"><i class="fas fa-plus-square mr-2"></i>Crear Usuario</a>
</div>

<div class="container" style="margin-top: 50px; margin-bottom: 40px;">
    @include('includes.status')
    @if (!isset($users))
    <div class="text-center d-flex mx-auto" style="background-color: white; width: 250px; height: 250px; border-radius: 10px; margin-bottom: 50px;">
        <div class="m-auto">
            <i class="fa fa-user" style="font-size: 50px; color: gray;"></i>
            <a href="{{route('user.register')}}" style="color: gray" class="text-decoration-none d-block mt-2">Crear Usuario</a>
        </div>
    </div>
    @endif
    <!-- Swiper -->
    <div class="row m-0 p-0">
        <div class="col m-0 p-0">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($users as $user)
                    @if ($user->user_id=== Auth::user()->id && $user->roles->id === 3)
                    <div class="swiper-slide d-flex align-items-end">
                        <div class="w-100 d-flex">
                            <div class="w-100 d-flex">
                                <div class="card" style="width: 18rem;">
                                    <img src="{{route('my.image', ['image' => $user->avatar])}}" height="250px" class="card-img-top p-2" alt="user-image">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between text-center align-items-center">
                                            <div>
                                                <h4 class="card-title">{{$user->name}}</h4>
                                                <p class="card-text" style="font-size: 14px;">{{$user->roles->name}}</p>
                                            </div>
                                            <a href="{{ route('edit.user', ['id' => $user->id]) }}" class="text-decoration-none" style="color: #2fcece"><i class="fas fa-pen"></i>
                                                <p>Editar</p>
                                            </a>
                                            <a href="{{route('delete.user', ['id' => $user->id])}}" class="text-decoration-none" style="color: #2fcece"><i class="fas fa-trash-alt"></i>
                                                <p>Borrar</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <!-- Add Pagination -->
                    <!-- <div class="swiper-pagination"></div> -->
                </div>
            </div>
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
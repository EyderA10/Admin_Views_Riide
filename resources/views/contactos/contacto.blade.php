@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'icon'))
<div class="container">
<div class="row mt-4 mb-2 p-3">
        <div class="col m-0 p-0">
            <div class="swiper-container" style="position:unset;">
                <div class="swiper-wrapper">
                    @foreach($contactos as $contacto)
                        @if ($contacto->user !== null)
                        <div class="swiper-slide d-flex align-items-end">
                            <div class="w-100 d-flex">
                                <div class="w-100 d-flex">
                                    <div class="card" style="width: 18rem;">
                                            <img src="{{$contacto->user->avatar}}" height="250px" class="card-img-top p-2" alt="user-image">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between text-center align-items-center">
                                                    <div>
                                                        <p class="card-title" style="font-size: 20px; margin-bottom: 0;">{{$contacto->asunto}}</p>
                                                        <p class="card-title" id="descripcion" style="font-size: 16px; margin-bottom: 0; height: 3rem; overflow: hidden;">{{$contacto->descripcion}}</p>
                                                    </div>
                                                <a href="#" class="text-decoration-none" onclick="handleOpenModal({!! $contacto->id !!})" data-target="#modal_contacto_user{{$contacto->id}}"style="color: #2fcece; font-size: 14px;">
                                                    <i class="far fa-eye"></i> Mas
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                <!-- Add Pagination -->
                <!-- <div class="swiper-pagination"></div> -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@foreach($contactos as $contacto)
@if ($contacto->user !== null)
<div class="modal fade" id="modal_contacto_user{{$contacto->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title mx-auto" id="exampleModalLabel">{{$contacto->user->name}}</h5>
                    </div>
                    <div class="modal-body">
                    <p> <span style="font-size: 18px; font-weight:bold">Asunto:</span> {{$contacto->asunto}}</p>
                    <p><span style="font-size: 16px; font-weight:bold">Descripcion:</span> {{$contacto->descripcion}}</p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
    </div>
</div>
@endif
@endforeach
<!-- Initialize Swiper -->
<script>

    function handleOpenModal(id) {
        $(`#modal_contacto_user${id}`).modal("show");
    }

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
@endsection
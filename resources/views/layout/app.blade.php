<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DashBoard</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!--CSS-->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{asset('css/clockpicker.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

    <!--SCRIPTS-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    

    <!--FontAwesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>

    <nav class="ment">
        <div style="background-color: #2fcece; width: 100%; height:80px; border-radius: 0 0 20px 20px; display: flex; justify-content: center">
            <img id="logo-blanco-riide" src="{{asset('img/LOGO EN BLANCO.png')}}" style="cursor: pointer;object-fit:contain; max-width: 4rem; width: 65%;" alt="logo-riide" />
            <script>
                document.getElementById('logo-blanco-riide').addEventListener('click', (e) => {
                    window.location.href = 'http://localhost:8000/admin/welcome';
                })
            </script>
        </div>
        <div style="width: 80%; height: 50px; margin: 0 auto; margin-top: 15px">
            <div class="d-flex align-items-center">
                <img class="ml-1" src="{{Auth::user()->avatar}}" style="width: 40px; height: 40px; border-radius: 100px;" alt="logo-user">
                <p style="font-size: 20px; color: white;" class="ml-2 mt-3">{{Auth::user()->name}}</p>
            </div>
        </div>
        <ul class="mt-4">
            @if (Auth::user()->roles->id === 7 || Auth::user()->roles->id === 2)
            <li class="mt-3">
                <a href="{{route('all.users')}}">
                    <i class="fa fa-user fa-2x"></i>
                    <span class="nav-text">
                        Usuarios
                    </span>
                </a>

            </li>
            <li class="mt-3">
                <a href="/sozdanie-korporativnogo-sajta.html">
                    <i class="fa fa-file-alt fa-2x"></i>
                    <span class="nav-text">
                        Categorias
                    </span>
                </a>

            </li>
            <li class="mt-3">
                <a href="{{route('all.tiendas')}}">
                    <i class="fa fa-store fa-2x"></i>
                    <span class="nav-text">
                        Tiendas
                    </span>
                </a>

            </li>
            <li class="mt-3">
                <a href="{{route('all.productos')}}">
                    <i class="fa fa-shopping-cart fa-2x"></i>
                    <span class="nav-text">
                        Productos
                    </span>
                </a>

            </li>
            @if (Auth::user()->roles->id === 7)
            <li class="mt-3">
                <a href="{{route('horarios')}}">
                    <i class="fa fa-clock fa-2x"></i>
                    <span class="nav-text">
                        Horarios
                    </span>
                </a>
            @endif
            </li>
            <li class="mt-3">
                <a href="{{route('all.banners')}}">
                    <i class="fa fa-file-import fa-2x"></i>
                    <span class="nav-text">
                        Banners
                    </span>
                </a>
            </li>
            @if (Auth::user()->roles->id === 2)
            <li class="mt-3">
                <a href="">
                <i class="fa fa-fire-alt fa-2x"></i>
                    <span class="nav-text">
                        Destacados
                    </span>
                </a>
            </li>
            <li class="mt-3">
                <a href="">
                <i class="fa fa-dollar-sign fa-2x"></i>
                    <span class="nav-text">
                        Cuentas por pagar
                    </span>
                </a>
            </li>
            <li class="mt-3">
                <a href="{{route('contactos')}}">
                <i class="fa fa-address-book fa-2x"></i>
                    <span class="nav-text">
                        Contactos
                    </span>
                </a>
            </li>
            @else
            <li class="mt-3">
                <a href="{{route('cuentas')}}">
                    <i class="fa fa-dollar-sign fa-2x"></i>
                    <span class="nav-text">
                        Estado de cuenta
                    </span>
                </a>
            </li>
            <li class="mt-3">
                <a href="{{route('index.cargam')}}">
                <i class="fa fa-cloud-upload-alt fa-2x"></i>
                    <span class="nav-text">
                        Carga masiva
                    </span>
                </a>
            </li>
            @endif
            @elseif (Auth::user()->roles->id === 3)
            <li class="mt-3">
                <a href="{{route('all.tiendas')}}">
                    <i class="fa fa-store fa-2x"></i>
                    <span class="nav-text">
                        Tiendas
                    </span>
                </a>

            </li>
            <li class="mt-3">
                <a href="{{route('all.productos')}}">
                    <i class="fa fa-shopping-cart fa-2x"></i>
                    <span class="nav-text">
                        Productos
                    </span>
                </a>

            </li>
            <li class="mt-3">
                <a href="{{route('horarios')}}">
                    <i class="fa fa-clock fa-2x"></i>
                    <span class="nav-text">
                        Horarios
                    </span>
                </a>

            </li>
            <li class="mt-3">
                <a href="{{route('all.banners')}}">
                    <i class="fa fa-file-import fa-2x"></i>
                    <span class="nav-text">
                        Banners
                    </span>
                </a>
            </li>
            <li class="mt-3">
                <a href="{{route('index.cargam')}}">
                <i class="fa fa-cloud-upload-alt fa-2x"></i>
                    <span class="nav-text">
                        Carga masiva
                    </span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    <main>
        @yield('content')
    </main>
    <footer class="footer-dashboard">
        &copy;Copyright Riide. All Rights Reserved
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('js/clockpicker.js')}}"></script>
</body>

</html>
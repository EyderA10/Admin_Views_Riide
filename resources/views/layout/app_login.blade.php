<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Admin</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!--CSS-->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <!--FontAwesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="d-flex justify-content-between align-items-center">
        <div class="div-riide-login">
            <img class="image-riide" src="{{asset('img/bg1.jpg')}}" alt="riide">
        </div>
        <div class="div-letras-riide">
            <img class="image-letras" src="{{asset('img/letras_riide.png')}}" alt="letras_riide">
        </div>
        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>
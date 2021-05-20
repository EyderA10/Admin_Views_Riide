@if (isset($name) && isset($icon) && !isset($sub))
<div class="menu-icon-user">
    <div class="float-left" style="margin-left: 45px;">
        <span class="icono-user-span"><i class="{{$icon}}"></i><a href="#" class="text-decoration-none letter-user">{{$name}}</a></span>
    </div>
    <div class="float-right dropdown">
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
@elseif (isset($name) && isset($sub) && isset($icon))
<div class="menu-icon-user">
    <div class="float-left" style="margin-left: 45px;">
        <span class="icono-user-span"><i class="{{$icon}}"></i> <a href="{{ route('all.users') }}" class="text-decoration-none letter-user">{{$name}} / <span style="color: gray; font-weight: bold;">{{$sub}}</span></a></span>
    </div>
    <div class="float-right">
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

@endif
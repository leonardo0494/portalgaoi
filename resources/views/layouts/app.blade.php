<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal GA OI</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/1469da1d47.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="wrapper">
        <div class="sidebar">
            <h2>Portal GA OI</h2>
            <ul>
                <li><a href="{{route("home")}}"><i class="fa fa-home"></i>&nbsp; Dashboard</a></li>
                <li><a href="{{route("atividades")}}"><i class="fa fa-tasks"></i>&nbsp; Atividades</a></li>
                {{-- <li><a href="{{route("calendario")}}"><i class="fa fa-calendar"></i>&nbsp; Calendário</a></li> --}}
                <li><a href="{{route('usuarios')}}"><i class="fa fa-users"></i>&nbsp; Usuários</a></li>
                <li><a href="{{route('perfil')}}"><i class="fa fa-user"></i>&nbsp; Perfil</a></li>
                <li><a href="{{route('logout')}}"><i class="fa fa-sign-out-alt"></i>&nbsp; Logout</a></li>
            </ul>
        </div>
        <div class="main">
            <nav class="navbar navbar-expand-lg navbar-dark bg-custom mb-4">
                <form action="#" method="POST" class="form-inline">
                    <input type="text" name="search-box" id="search-box" class="search-box" placeholder="Buscar Atividade...">
                </form>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{  asset( 'storage/imagens/' . \Auth::user()->profile_image . '') }}" class="user-image"> 
                                &nbsp; Olá, {{ explode(' ', \Auth::user()->name)[0] }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('perfil')}}">Editar Perfil</a>
                                <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- CUSTOM JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
    {{-- CK EDITOR --}}
    <script src="http://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace ("description")
    </script>
</body>

</html>

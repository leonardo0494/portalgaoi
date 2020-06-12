<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <li><a href="{{route('list-reports')}}"><i class="fas fa-hourglass-end"></i>&nbsp; Relatório de Horas</a></li>
                {{-- <li><a href="{{route("calendario")}}"><i class="fa fa-calendar"></i>&nbsp; Calendário</a></li> --}}
                <li><a href="{{route('usuarios')}}"><i class="fa fa-users"></i>&nbsp; Usuários</a></li>
                <li><a href="{{route('perfil')}}"><i class="fa fa-user"></i>&nbsp; Perfil</a></li>
                <li><a href="#"><i class="fas fa-link"></i>&nbsp; Links Úteis</a>
                    <ul>
                        <li><a href="http://portalbackup.telemar/">Portal Backup</a></li>
                        <li><a href="http://portalcmdb/relGenerico.asp">Portal CMDB</a></li>
                        <li><a href="http://10.32.202.36/doc/index.php?class=ViewList&method=onReload">Monitor de Defeitos</a></li>
                        <li><a href="http://10.58.198.137:8080/midtier_linux/shared/login.jsp">Remedy</a></li>
                        <li><a href="http://sharepoint/tecnologia/0066/Procedimentos%20GAOI/Forms/AllItems.aspx">Sharepoint GA OI</a></li>
                        <li><a href="http://fep">FEP</a></li>
                    </ul>
                </li>
                <li><a href="{{route('logout')}}"><i class="fa fa-sign-out-alt"></i>&nbsp; Logout</a></li>
            </ul>
        </div>
        <div class="main">
            <nav class="navbar navbar-expand-lg navbar-dark bg-custom mb-4">
                <button type="button" class="btn btn-sm btn-success pt-2" id="iniciar-atividade"><i class="fas fa-play"></i> &nbsp; Iniciar Atividade</button>
                <div class="contador text-white d-none" id="contador-atividade">
                    <button type="button" class="btn btn-sm btn-danger pt-2 open-modalStop" id="parar-atividade" data-toggle="modal" data-target="#modalReport"><i class="fas fa-stop"></i> &nbsp; Parar Atividade</button> &nbsp;
                    <span id="horasAtividade">00:00:00</span>
                </div>
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

    <!-- Modal -->
    <div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="modalReport" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalReportLabel">Informações da Atividade</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('save-reports')}}" method="POST">
                    @csrf
                    <input type="hidden" name="hora-inicio-real" id="hora-inicio-real" class='d-none'>
                    <input type="hidden" name="hora-fim-real" id="hora-fim-real" class="d-none">
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo" class="form-control">
                            <option value="">Selecione o tipo de atividade</option>
                            <option value="DEFEITO">DEFEITO</option>
                            <option value="DEFEITO_ARS">DEFEITO + ARS</option>
                            <option value="CALL">CALL</option>
                            <option value="ARS">ARS</option>
                            <option value="MELHORIAS">MELHORIAS</option>
                            <option value="MONITORAMENTO">MONITORAMENTO</option>
                            <option value="TREINAMENTO">TREINAMENTO</option>
                            <option value="RELATORIOS">RELATORIOS</option>
                            <option value="REUNIÃO">REUNIÃO</option>
                        </select>
                    </div>

                    <div class="d-none" id="cod">
                        <div class="form-group">
                            <label for="prj_ent">PRJ_ENT</label>
                            <input type="text" name="prj_ent" id="prj_ent" placeholder="Ex: PRJ0001234_ENT00004567" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="defeito">Defeito</label>
                            <input type="text" name="defeito" id="defeito" placeholder="Ex: 765" class="form-control" />
                        </div>
                    </div>

                    <div class="d-none" id="ars">
                        <div class="form-group">
                            <label for="chamado">ARS</label>
                            <input type="text" name="chamado" id="chamado" placeholder="Ex: 000000012345678" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="pendencia">Pendência</label>
                            <select name="pendencia" id="pendencia" class="form-control">
                                <option value="NAO" selected>Não</option>
                                <option value="SIM">Sim</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group d-none" id="sys">
                        <label for="sistema">Sistema</label>
                        <input type="text" class="form-control" name='sistema' placeholder="Ex: SIEBEL 6.3" />
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control" rows="3" col="30" name='descricao' maxlength="180" placeholder="Limite de 180 caracteres..."></textarea>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label for="hora-inicio">Data e Hora Inicio</label>
                            <input type="text" name="horainicio" id="hora-inicio" class="form-control" disabled>
                        </div>
                        <div class="col-6">
                            <label for="hora-fim">Data e Hora Fim</label>
                            <input type="text" name="horafim" id="hora-fim" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
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
    <script src="{{ asset('js/atividade.js?v0.4') }}"></script>
    {{-- CK EDITOR --}}
    <script src="http://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace ("description")
    </script>

    <script>
        $(document).ready(function() {
            $(".open-modalStop").click(() => {
                $('#modalReport').modal('show');
            });
        });
    </script>

</body>

</html>

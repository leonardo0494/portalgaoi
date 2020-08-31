<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal GA OI</title>
    {{-- CUSTOM CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- BOOTSTRAP --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    {{-- SELECT 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    {{-- Daterangepicker --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/1469da1d47.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="wrapper" id="app">
        <div class="sidebar">
            <h2>Portal GA OI</h2>
            <ul>
                <li><a href="{{route("inicial")}}"><i class="fa fa-home"></i>&nbsp; Dashboard</a></li>
                <li><a href="{{route("atividades")}}"><i class="fa fa-tasks"></i>&nbsp; Atividades</a></li>
                <li><a href="{{route('list-reports')}}"><i class="fas fa-hourglass-end"></i>&nbsp; Relatório de Horas</a></li>
                @if(Auth::user()->level_id == 1)
                    <li><a href="{{route("plantao")}}"><i class="fa fa-calendar"></i>&nbsp; Plantão</a></li>
                @endif
                <li><a href="{{route('usuarios')}}"><i class="fa fa-users"></i> Usuários</a></li>
                <li><a href="{{route('perfil')}}"><i class="fa fa-user"></i>&nbsp; Perfil</a></li>
		<li><a href="{{route('sobre')}}"><i class="fas fa-question-circle"></i>&nbsp;Sobre</a></li>
	        <li><a href="{{route('check-netwin')}}"><i class="fas fa-server"></i>&nbsp;Serviços Netwin</a></li>
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
                @if( !(\Route::current()->getName() == 'save-reports'))
                    <a href="{{route('save-reports')}}" class="btn btn-sm btn-danger pt-2 d-none" id='fechar-atividade'><i class="fas fa-stop"></i> &nbsp; Finalizar Atividade</a>
                    <button type="button" class="btn btn-sm btn-success pt-2" id="iniciar-atividade"><i class="fas fa-play"></i> &nbsp; Iniciar Atividade</button>
                    <div class="contador text-white d-none" id="contador-atividade">
                        <form action="{{route('atividade-finalizada')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id-atividade" id='id-atividade' class="d-none" hidden>
                            <button type="submit" class="btn btn-sm btn-danger pt-2" id="parar-atividade" ><i class="fas fa-stop"></i> &nbsp; Parar Atividade</button> &nbsp;
                            {{-- <span id="horasAtividade">00:00:00</span> --}}
                        </form>
                    </div>
                @endif
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <ul class="navbar-nav ml-auto">
                        <form class="form-inline mr-4">
                            <input type="search" name="ars_number" id="pesquisar_numero_ars" class="search-box form-control-sm mr-3" placeholder="Informe o número do ARS...">
                            <button type="submit" class="btn btn-sm btn-outline-secondary" id="pesquisar-ars">Buscar ARS</button>
                        </form>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{  asset( 'storage/imagens/' . \Auth::user()->profile_image . '') }}" class="user-image">
                                &nbsp; Olá, {{ explode(' ', \Auth::user()->name)[0] }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->level_id == 1)
                                    <a class="dropdown-item" href="{{route('sistemas')}}">Atualizar Sistemas</a>
                                @endif
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
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <!-- CUSTOM JS -->
    <script src="{{ asset('js/mask.js?') }}"></script>
    <script src="{{ asset('js/custom.js?v0.9') }}"></script>
    <script src="{{ asset('js/sobre.js') }}"></script>
    <script src="{{ asset('js/atividades.js?v0.4') }}"></script>
    <script src="{{ asset('js/atividade-personalizada.js?v0.10') }}"></script>
    <script src="{{ asset('js/plantao.js') }}"></script>
    {{-- CK EDITOR --}}
    <script src="http://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    {{-- Daterangepicker --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        CKEDITOR.replace ("description")
    </script>

    {{-- SELECT2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-2-personalizado').select2({
                width: '100%'
            });

            $('.select2-multiple-personalizado').select2({
                width: '100%',
                placeholder: "Selecione os usuários"
            });

            $(".datarangepicker").daterangepicker({
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Ok",
                    "cancelLabel": "Cancel",
                    "fromLabel": "De",
                    "toLabel": "Para",
                    "customRangeLabel": "Customizado",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Dom",
                        "Seg",
                        "Ter",
                        "Qua",
                        "Qui",
                        "Sex",
                        "Sáb"
                    ],
                    "monthNames": [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro"
                    ],
                    "firstDay": 0
                },
            });

            $(".data_gmud").daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
                locale: {
                    "format": "DD/MM/YYYY H:mm:ss",
                    "separator": " - ",
                    "applyLabel": "Ok",
                    "cancelLabel": "Cancel",
                    "fromLabel": "De",
                    "toLabel": "Para",
                    "customRangeLabel": "Customizado",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Dom",
                        "Seg",
                        "Ter",
                        "Qua",
                        "Qui",
                        "Sex",
                        "Sáb"
                    ],
                    "monthNames": [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro"
                    ],
                    "firstDay": 0
                },
            })

            $(".detalhes-tarefa").click(function(){
                    let reportId = $(this).data('id');

                    $.ajax({
                        method: 'get',
                        url: 'detalhe-atividade',
                        data: {
                            id: reportId
                        }
                    }).done( response => {

                        let html = "";

                        html += `
                            <h5 style="font-weight: bold">Tipo Atividade</h5>
                            <p style="font-size: 14px;">${response.reports.tipo}</p>
                        `;

                        html += `
                            <h5 style="font-weight: bold">Tempo Atendimento</h5>
                            <p style="font-size: 14px;">${response.reports.tempo_atendimento}</p>
                        `;

                        if(response.reports.tipo == "DEFEITO" || response.reports.tipo == "CALL" ){
                            html += `
                                <h5 style="font-weight: bold">Defeitos</h5>
                                <table class="table table-bordered">
                            `;

                            response.defeitos.forEach( defeito => {
                                html += `
                                    <tr>
                                        <td>${defeito.def}</td>
                                        <td>${defeito.prj_ent}</td>
                                    </tr>
                                `;
                            });

                            html += `</table>`;

                            html += `
                                <h5 style="font-weight: bold">Sistema</h5>
                                <p style="font-size: 14px;">${response.reports.sistema}</p>
                            `;

                        }

                        if(response.reports.tipo == "ARS" || response.ars.length > 0 ){
                            html += `
                                <h5 style="font-weight: bold">ARS</h5>
                                <p style="font-size: 14px;">${response.ars[0].ars ? response.ars[0].ars : '-'}</p>
                            `;

                            html += `
                                <h5 style="font-weight: bold">Pendência</h5>
                                <p style="font-size: 14px;">${response.ars[0].pendencia}</p>
                            `;

                            if (response.reports.tipo == "ARS") {
                                html += `
                                    <h5 style="font-weight: bold">Sistema</h5>
                                    <p style="font-size: 14px;">${response.reports.sistema}</p>
                                `;
                            }

                        }

                        if(response.reports.tipo== 'MELHORIAS' || response.reports.tipo== "MONITORAMENTO" || response.reports.tipo== "TREINAMENTO"){

                            html += `
                                <h5 style="font-weight: bold">Sistema</h5>
                                <p style="font-size: 14px;">${response.reports.sistema}</p>
                            `;

                        }

                        html += `
                            <h5 style="font-weight: bold">Descrição</h5>
                            <p style="font-size: 14px;">${response.reports.descricao}</p>
                        `;

                        $("#reportsDetails").html(html);

                });

            });
        });
    </script>
</body>

</html>

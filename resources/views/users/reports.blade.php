@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">Relatório de Horas</li>
    </ol>
</nav>
<div class="col-md-12 pb-4">

    @if(Auth::user()->level_id == 1)
        <div class="row mb-3">
            <div class="col-12 px-0">
                <div class="card">
                    <div class="card-header">Filtros</div>
                    <div class="card-body">
                        <form action="{{route('filtrar-reports')}}" method="GET">
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="recurso">Usuário</label>
                                    <select name="usuario" id="recurso" class="form-control">
                                        <option value="">Selecione um Usuário</option>
                                        @foreach ($Usuarios as $usuario)
                                            <option value="{{$usuario->rowid}}" @if(isset($_GET['usuario'])) @if($_GET['usuario'] == $usuario->rowid) selected @endif @endif >{{$usuario->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-2">
                                    <label for="data-range-inicio">Data Inicio</label>
                                    <input type="text" name="data_range_inicio" placeholder="dd/mm/yyyy" @if(isset($_GET['data_range_inicio'])) value="{{ $_GET['data_range_inicio']}}" @endif id="data-range-inicio" class="form-control data-mask">
                                </div>
                                <div class="form-group col-2">
                                    <label for="data-range-fim">Data Fim</label>
                                    <input type="text" name="data_range_fim" placeholder="dd/mm/yyyy" @if(isset($_GET['data_range_fim'])) value="{{ $_GET['data_range_fim']}}" @endif id="data-range-fim" class="form-control data-mask data-range-fim">
                                </div>
                                <div class="form-group col-3">
                                    <label for="tipo">Tipo Atividade</label>
                                    <select name="tipo" id="tipo" class="form-control">
                                        <option value="">Selecione um tipo</option>
                                        <option value="DEFEITO" @if(isset($_GET['tipo'])) @if($_GET['tipo'] == "DEFEITO") selected @endif @endif>DEFEITO</option>
                                        <option value="CALL" @if(isset($_GET['tipo'])) @if($_GET['tipo'] == "CALL") selected @endif @endif>CALL</option>
                                        <option value="ARS" @if(isset($_GET['tipo'])) @if($_GET['tipo'] == "ARS") selected @endif @endif>ARS</option>
                                        <option value="MELHORIAS" @if(isset($_GET['tipo'])) @if($_GET['tipo'] == "MELHORIAS") selected @endif @endif>MELHORIAS</option>
                                        <option value="MONITORAMENTO" @if(isset($_GET['tipo'])) @if($_GET['tipo'] == "MONITORAMENTO") selected @endif @endif>MONITORAMENTO</option>
                                        <option value="TREINAMENTO" @if(isset($_GET['tipo'])) @if($_GET['tipo'] == "TREINAMENTO") selected @endif @endif>TREINAMENTO</option>
                                        <option value="RELATORIOS" @if(isset($_GET['tipo'])) @if($_GET['tipo'] == "RELATORIOS") selected @endif @endif>RELATORIOS</option>
                                        <option value="REUNIÃO" @if(isset($_GET['tipo'])) @if($_GET['tipo'] == "REUNIÃO") selected @endif @endif>REUNIÃO</option>
                                    </select>
                                </div>
                                <div class="form-group col-1">
                                    <label for="enviar" class="mb-2">&nbsp;</label><br>
                                    <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="text-align: center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>TIPO</th>
                        <th>DESCRICAO</th>
                        <th>INICIO ATENDIMENTO</th>
                        <th>FINAL ATENDIMENTO</th>
                        <th>TEMPO ATENDIMENTO</th>
                        <th>USUÁRIO</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($relatorios as $relatorio)
                        <tr>
                            <td>{{$relatorio->id}}</td>
                            <td>{{$relatorio->tipo}}</td>
                            <td>{{$relatorio->descricao}}</td>
                            <td>{{$relatorio->inicio_atendimento}}</td>
                            <td>{{$relatorio->final_atendimento}}</td>
                            <td>{{$relatorio->tempo_atendimento}}</td>
                            <td>{{$relatorio->username}}</td>
                            <td><i class="fas fa-eye detalhes-tarefa" data-target="#modalReports" data-toggle="modal" data-id="{{$relatorio->id}}" style="cursor: pointer;"></i></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Reports -->

        <div class="modal fade" id="modalReports" tabindex="-1" role="dialog" aria-labelledby="modalReportsTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Detalhes da Atividade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="reportsDetails">
                    </div>
                </div>
		    </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-10 d-flex justify-content-start pl-0">
            {{$relatorios->links()}}
        </div>
        <div class="col-md-2 pr-0">
            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#exportarDados">
                Exportar Dados
            </button>
        </div>
    </div>

    <div class="row d-none">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">

                    <h5 style="font-weight: bold">Tipo Tarefa</h5>
                    <p style="font-size: 14px;">ARS</p>

                    <h5 style="font-weight: bold">ARS</h5>
                    <p style="font-size: 14px;">000000012345678</p>

                    <h5 style="font-weight: bold">Defeitos</h5>
                    <table class="table">
                        <tr>
                            <td>12345</td>
                            <td>PRJ00001234_ENT00001234</td>
                        </tr>
                        <tr>
                            <td>12345</td>
                            <td>PRJ00001234_ENT00001234</td>
                        </tr>
                        <tr>
                            <td>12345</td>
                            <td>PRJ00001234_ENT00001234</td>
                        </tr>
                    </table>

                    <h5 style="font-weight: bold">Sistema</h5>
                    <p style="font-size: 14px;">SIEBEL</p>

                    <h5 style="font-weight: bold">Descrição</h5>
                    <p style="font-size: 14px;">Lorem ipsum dolor sit amet consectetur adipisicing</p>

                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exportarDados" tabindex="-1" role="dialog" aria-labelledby="exportarDados" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Exportação - Relatório de Horas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('exportar-reports')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="data_inicial">Selecione o período.</label>
                    <input type="text" name="periodo_exportacao" id="data-range-inicio" class="form-control datarangepicker" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Concluir Exportação</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection

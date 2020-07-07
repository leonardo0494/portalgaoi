@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">Relatório de Horas</li>
    </ol>
</nav>
<div class="col-md-12 pb-4">
   
    <div class="row">
        <h3>&nbsp;</h3>
    </div>
    
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="text-align: center">
                <thead>
                    <tr>
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
                            <td>{{$relatorio->tipo}}</td>
                            <td>{{$relatorio->descricao}}</td>
                            <td>{{$relatorio->inicio_atendimento}}</td>
                            <td>{{$relatorio->final_atendimento}}</td>
                            <td>{{$relatorio->tempo_atendimento}}</td>
                            <td>{{$relatorio->username}}</td>
                            <td><i class="fas fa-eye" data-id="{{$relatorio->id}}" style="cursor: pointer;" onclick="alert('Funcionalidade em construcao.')"></i></td>
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
        <div class="col-md-12 d-flex justify-content-end pr-0">
            {{$relatorios->links()}}
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
@endsection

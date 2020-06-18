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
            <table class="table table-users table-bordered table-hover" style="text-align: center">
                <thead>
                    <tr>
                        <th>TIPO</th>
                        <th>DESCRICAO</th>
                        <th>INICIO ATENDIMENTO</th>
                        <th>FINAL ATENDIMENTO</th>
                        <th>TEMPO ATENDIMENTO</th>
                        <th>USUÁRIO</th>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Reports -->

        {{-- <div class="modal fade" id="modalReports" tabindex="-1" role="dialog" aria-labelledby="modalReportsTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detalhes da Atividade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <p>
                        <strong>Horário -</strong> <span id="hour-activity">23/03/2020 15:40 - 23/03/2020 18:00</span> <br>
                        <strong>Tempo Total de Atividade: </strong> 00:15 <br>
                        <strong>Tipo Atividade -</strong> Defeito <br>
                        <strong>ARS: </strong> 12345678 <br>
                        <strong>Sistema: </strong> SIEBEL
                    </p>
                    <hr />
                    <strong>Defeitos: </strong>

                    <ul>
                        <li>1234 - PRJ0001211_ENT00012112</li>
                        <li>1234 - PRJ0001211_ENT00012112</li>
                    </ul>

                    <p>
                        <strong>Descrição:</strong><br>
                        <span id="body-activity">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Modi autem ab quaerat repudiandae cupiditate molestias commodi corrupti ut laudantium voluptate doloremque beatae ullam expedita, magni doloribus minus voluptatem dicta. Cum?
                        </span>
                    </p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            </div>
        </div> --}}

    </div>
</div>
@endsection
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
    </div>
</div>
@endsection
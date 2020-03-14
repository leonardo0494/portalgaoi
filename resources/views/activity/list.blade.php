@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Atividades</li>
        </ol>
    </nav>

    <div class="col-md-12">
    <div class="row mb-1">
        <div class="col-md-10 pl-0 pt-2">
            <h3>Atividades</h3>
        </div>
        @if(\Auth::user()->level_id == 1)
            <div class="col-md-2 text-right p-0">
                <button type="button" class="btn btn-success" data-toggle='modal' data-target='#cadastrar-atividade'>Nova Atividade</button>
            </div>
        @endif
    </div>
    <div class="row">
        @if(\Auth::user()->level_id == 1)
            <table id="tabela-atividades" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Tipo</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Executor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($atividades) == 0)
                        <tr>
                            <td colspan="6" class='text-center'>Cadastre uma atividade para ela aparecer aqui :)</td>
                        </tr>
                    @else
                        @foreach($atividades as $atividade)
                            <tr>
                                <td>{{ $atividade->ars_number }}</td>
                                <td>{{ $atividade->ttype }}</td>
                                <td>{{ \App\Utils::converterDataParaPadraoBrasileiro($atividade->start_date) }}</td>
                                <td>{{ \App\Utils::converterDataParaPadraoBrasileiro($atividade->end_date) }}</td>
                                <td>{{ \App\User::where('rowid', $atividade->user_id)->first(['name'])->name }}</td>
                                <td>{{ $atividade->status }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @else
            <table id="tabela-atividades" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Tipo</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($atividades) == 0)
                        <tr>
                            <td colspan="6" class='text-center'>Não foram cadastradas atividades para você ainda :)</td>
                        </tr>
                    @else
                        @foreach($atividades as $atividade)
                            <tr>
                                <td>{{ $atividade->ars_number }}</td>
                                <td>{{ $atividade->ttype }}</td>
                                <td>{{ \App\Utils::converterDataParaPadraoBrasileiro($atividade->start_date) }}</td>
                                <td>{{ \App\Utils::converterDataParaPadraoBrasileiro($atividade->end_date) }}</td>                               
                                <td>{{ $atividade->status }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- MODAL DE CADASTRAR ATIVIDADES --}}
<div class="modal fade" id="cadastrar-atividade" tabindex="-1" role="dialog" arial-labelledby='cadastrar-atividade-label' aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('cadastrar-atividade')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastrar-atividade-label">Cadastrar Atividade</h5>
                    <button type="button" class="close" data-dismiss='modal' aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ars_number">Número ARS/GMUD</label>
                        <input type="text" name="ars_number" id="ars_number" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="start_date">Data Início</label>
                                <input type="text" name="start_date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date">Data Fim</label>
                                <input type="text" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ttype">Tipo Atividade</label>
                        <select name="ttype" id="ttype" class="form-control" required>
                            {{-- <option value="ARS">ARS</option> --}}
                            <option value="GMUD" selected>GMUD</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user_id">Executor</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option>Selecione o executor</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{$usuario->rowid}}">{{$usuario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection
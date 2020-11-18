@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Editar Atividade</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h5 class="modal-title" id="modalReportLabel">Informações da Atividade</h5>
        </div>
        <div class="card-body">
            <form action="{{route('update-report')}}" method="POST">
                @csrf
                <input type="hidden" name="id-atividade" value="{{$reports->id}}" class="d-none">

                {{-- DATAS --}}
                <div class="form-group row">
                    <div class="col-6">
                        <label for="hora-inicio">Data e Hora Inicio</label>
                        <input type="text" name="horainicio" id="hora-inicio" class="form-control" value="{{ \App\Utils::converterDataParaPadraoBrasileiro($reports->inicio_atendimento)}}">
                    </div>
                    <div class="col-6">
                        <label for="hora-fim">Data e Hora Fim</label>
                        <input type="text" name="horafim" id="hora-fim" class="form-control" value="{{\App\Utils::converterDataParaPadraoBrasileiro($reports->final_atendimento)}}">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-12">
                        <p class="small text-danger"><strong>IMPORTANTE: </strong> Você só poderá editar essa atividade uma vez.</p>
                    </div>
                </div>

                <div class="card-footer pl-0">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

@endsection

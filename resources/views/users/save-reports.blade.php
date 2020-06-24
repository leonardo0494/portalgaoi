@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Salvar Atividade</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h5 class="modal-title" id="modalReportLabel">Informações da Atividade</h5>
        </div>
        <div class="card-body">
            <form action="{{route('save-reports')}}" method="POST">
                @csrf
                <input type="hidden" name="hora-inicio-real" id="hora-inicio-real" value="{{$activityOnline->hora_inicio}}" class='d-none'>
                <input type="hidden" name="hora-fim-real" id="hora-fim-real" value="{{$activityOnline->hora_termino}}" class="d-none">
                <input type="hidden" name="id-atividade" value="{{$activityOnline->id}}" class="d-none">
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
                    <div class="row">
                        <div class="col-12">
                            <table class="table" id="table-def-prj">
                                <thead>
                                    <th>PRJ_ENT</th>
                                    <th>DEFEITO</th>
                                    <th width=1 class="text-center"><button type="button" class="btn btn-sm btn-md btn-primary" id="add-line-def"><i class="fas fa-plus"></i></button></th>
                                </thead>
                                <tbody>
                                    <tr class="first-line">
                                        <td><input type="text" name="prj_ent[]" id="prj_ent" maxlength="24" placeholder="Ex: PRJ0001234_ENT00004567" class="form-control" /></td>
                                        <td><input type="text" name="defeito[]" id="defeito" maxlength="5" placeholder="Ex: 765" class="form-control" /></td>
                                        <td class="text-center pt-3">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-none" id="ars">
                    <div class="form-group">
                        <label for="chamado">ARS</label>
                        <input type="text" name="chamado" id="chamado" placeholder="Ex: 000000012345678"  maxlength="14" class="form-control" />
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
                    <!-- <input type="text" class="form-control" name='sistema' placeholder="Ex: SIEBEL 6.3" /> -->
                    <select name="sistema" id="sistema" class="form-control">
                        @foreach($sistemas as $sistema)
                            <option value="{{ $sistema->sistema }}">{{ $sistema->sistema }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" rows="3" col="30" name='descricao' maxlength="50" placeholder="Limite de 50 caracteres..."></textarea>
                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label for="hora-inicio">Data e Hora Inicio</label>
                        <input type="text" name="horainicio" id="hora-inicio" class="form-control" value="{{$activityOnline->hora_inicio}}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="hora-fim">Data e Hora Fim</label>
                        <input type="text" name="horafim" id="hora-fim" class="form-control" value="{{$activityOnline->hora_termino}}" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>

@endsection

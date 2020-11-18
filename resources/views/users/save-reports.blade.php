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
                    <select name="tipo" id="tipo-atividade" class="form-control" required>
                        <option value="">Selecione o tipo de atividade</option>
                        <option value="DEFEITO">DEFEITO</option>
                        <option value="CALL">CALL</option>
                        <option value="ARS">ARS</option>
                        <option value="MELHORIAS">MELHORIAS</option>
                        <option value="MONITORAMENTO">MONITORAMENTO</option>
                        <option value="TREINAMENTO">TREINAMENTO</option>
                        <option value="RELATORIOS">RELATORIOS</option>
                        <option value="REUNIÃO">REUNIÃO</option>
                    </select>
                </div>

                {{-- ARS/DEF CHECKBOX --}}
                <div class="row">
                    <div class="col-12">
                        <span id="ars-opc" class="d-none">
                            <input type="checkbox" id="show_ars" name="show_ars">
                            <label for="show_ars">Tem ARS?</label>
                        </span>
                        &nbsp; &nbsp;
                        <span id="def-opc" class="d-none">
                            <input type="checkbox" id="show_defeito" name="show_def">
                            <label for="checkbox">Tem Defeito?</label>
                        </span>
                    </div>
                </div>

                {{-- ARS INPUTS --}}
                <div class="row d-none" id="ars">
                    {{-- INPUT ARS --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label for="chamado">ARS</label>
                            <input type="text" name="chamado" id="chamado" placeholder="Ex: 000000012345678"  maxlength="14" class="form-control" />
                        </div>
                    </div>

                    {{-- CATEGORIA DO ARS --}}
                    <div class="col-5">
                        <div class="form-group" id='ars-cat'>
                            <label for="categorie-ars">Categoria do <strong>ARS</strong></label>
                            <select name="categorie-ars" id="categorie-ars" class="form-control">
                                <option value="">Selecione uma categoria</option>
				                <option value="DEFEITO">DEFEITO</option>
                                <option value="MIGRACAO">MIGRACAO</option>
                                <option value="MANUTENCAO">MANUTENCAO</option>
                                <option value="SUPORTE A TESTE">SUPORTE A TESTE</option>
                            </select>
                        </div>
                    </div>

                    {{-- PENDENCIA ARS --}}
                    <div class="col-3">
                        <div class="form-group">
                            <label for="pendencia" class="pb-2">Pendência</label><br>
                            <input type="radio" name="pendencia" class="pendencia" id="pendencia" value='NAO' checked> Nao &nbsp;
                            <input type="radio" name="pendencia" class="pendencia" id="pendencia" value='SIM'> Sim
                        </div>
                    </div>
                </div>

                {{-- DEFEITO INPUTS --}}
                <div class="row d-none" id="defeito">

                    {{-- DEFEITOS --}}
                    <div class="col-12">
                        <table class="table" id="table-def-prj">
                            <thead>
                                <th>PRJ_ENT</th>
                                <th>DEFEITO</th>
                                <th width=1 class="text-center"><button type="button" class="btn btn-sm btn-md btn-primary" id="add-line-def"><i class="fas fa-plus"></i></button></th>
                            </thead>
                            <tbody>
                                <tr class="first-line">
                                    <td><input type="text" name="prj_ent[]" id="prj_ent" maxlength="24" placeholder="Ex: PRJ0001234_ENT00004567" class="form-control"/></td>
                                    <td><input type="text" name="defeito[]" id="defeito" maxlength="5" placeholder="Ex: 765" class="form-control"/></td>
                                    <td class="text-center pt-3"><button type="button" class="btn btn-sm btn-md btn-danger" disabled><i class="far fa-trash-alt"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- CATEGORIA DEFEITO --}}
                    <div class="col-12">
                        <div class="form-group" id="cat-defeito">
                            <label for="categorie-def">Categoria do <strong>Defeito</strong></label>
                            <select name="categorie-def" id="categorie-def" class="form-control">
                                <option value="">Selecione uma categoria</option>
                                <option value="CODIGO">CODIGO</option>
                                <option value="INVESTIGACAO">INVESTIGACAO</option>
                                <option value="REJEITADO">REJEITADO</option>
                                <option value="ERRO DE MIGRACAO">ERRO DE MIGRACAO</option>
				<option value="MODELO DE DADOS">MODELO DE DADOS</option>
                                <option value="INDISPONIBILIDADE">INDISPONIBILIDADE</option>
                                <option value="PARAMETRIZACAO">PARAMETRIZACAO DE AMBIENTE</option>
				<option value="AMBIENTE">AMBIENTE</option>
                                <option value="INFRAESTRUTURA">INFRAESTRUTURA</option>
                            </select>
                        </div>
                    </div>

                </div>

                {{-- SISTEMA INPUTS --}}
                <div class="form-group d-none" id="sistema">
                    <label for="sistema">Sistema</label><br>
                    <!-- <input type="text" class="form-control" name='sistema' placeholder="Ex: SIEBEL 6.3" /> -->
                    <select name="sistema" id="sistema" class="form-control select-2-personalizado">
                        @foreach($sistemas as $sistema)
                            <option value="{{ $sistema->sistema }}">{{ $sistema->sistema }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- DESCRICAO --}}
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" rows="3" col="30" name='descricao' maxlength="50" placeholder="Limite de 50 caracteres..." required></textarea>
                </div>

                {{-- DATAS --}}
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

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>

@endsection

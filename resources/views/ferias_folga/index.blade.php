@extends('layouts.app')

@section('content')

    @if(session()->has('status'))
        <div class='alert alert-success' id='mensagem-atividade'>
            {{ session('status')}}
            @php
                session()->forget('status');
            @endphp
        </div>
    @endif

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Férias/Folga</li>
        </ol>
    </nav>

    {{-- FERIAS/FOLGAS A SEGUIR --}}
    <div class="row mt-3 mb-0">
        <div class="col-11 pt-2">
            <h3>Quadro de Férias e Folga</h3>
        </div>
    </div>

    <hr />

    {{-- FERIAS/FOLGAS A SEGUIR LISTAGEM --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Recurso</th>
                            <th>Tipo</th>
                            <th>Período</th>
                            <th width="3%">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuariosEmRecesso as $feriasFolga)
                            <tr>
                                <td>{{$feriasFolga->username}}</td>
                                <td>{{$feriasFolga->tipo}}</td>
                                @if($feriasFolga->tipo == "FOLGA" && $feriasFolga->start_date_mod == $feriasFolga->end_date_mod)
                                    <td>{{$feriasFolga->start_date_mod}}</td>
                                @else
                                    <td>{{$feriasFolga->start_date_mod}} - {{$feriasFolga->end_date_mod}}</td>
                                @endif
                                <td><a href="{{route('excluir-ferias-folga', ['id' => $feriasFolga->id])}}" onclick="if(confirm('Deseja realmente deletar esse registro?') == false) return false;">Excluir</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(Auth::user()->level_id == 1)

        {{-- CADASTRAR FÉRIAS/FOLGA --}}
        <div class="row mb-0">
            <div class="col-11 pt-2">
                <h3>Férias/Folga da Equipe</h3>
            </div>
            <div class="col-1 text-right">
                <button class="btn btn-sm btn-dark pb-2 d-none" id="minimize"><i class="fas fa-window-minimize" style="font-size: 12px"></i></button>
                <button class="btn btn-sm btn-dark no-border pt-2"  id="maxmize"><i class="far fa-window-maximize"></i></button>
            </div>
        </div>

        <hr />

        {{-- CADASTRAR FÉRIAS/FOLGA FORMULÁRIO --}}
        <div class="card pb-0 mb-0" id="cadastrar-plantao">
            <div class="card-body">

                <div class="row" id="adicionar-plantao">
                    <div class="col-8">
                        <form action="{{route('salvar-ferias-folga')}}" method="POST">
                            @csrf

                            {{-- SEMANA 1 --}}
                            <div class="row">
                                <div class="col-4">
                                    <label for="data">SEMANA/DIA/MÊS das Férias/Folga</label>
                                    <input type="text" name="semana1" class="form-control datarangepicker" value="" placeholder="Selecione uma data">
                                </div>
                                <div class="col-4">
                                    <label for="users">TIPO</label>
                                    <select name="usuario-tipo-1" id="usuario-tipo-1" class="form-control">
                                        <option value="FÉRIAS">FÉRIAS</option>
                                        <option value="FOLGA">FOLGA</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="users">Usuário</label>
                                    <select name="usuarios-semana-1" class="form-control select2">
                                        <option value="">Selecione um Usuário</option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->rowid}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- SEMANA 2 --}}
                            <div class="row mt-3">
                                <div class="col-4">
                                    <label for="data">SEMANA/DIA/MÊS das Férias/Folga</label>
                                    <input type="text" name="semana2" class="form-control datarangepicker" value="" placeholder="Selecione uma data">
                                </div>
                                <div class="col-4">
                                    <label for="users">TIPO</label>
                                    <select name="usuario-tipo-2" id="usuario-tipo-2" class="form-control">
                                        <option value="FÉRIAS">FÉRIAS</option>
                                        <option value="FOLGA">FOLGA</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="users">Usuário</label>
                                    <select name="usuarios-semana-2" class="form-control select2">
                                        <option value="">Selecione um Usuário</option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->rowid}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- SEMANA 3 --}}
                            <div class="row mt-3">
                                <div class="col-4">
                                    <label for="data">SEMANA/DIA/MÊS das Férias/Folga</label>
                                    <input type="text" name="semana3" class="form-control datarangepicker" value="" placeholder="Selecione uma data">
                                </div>
                                <div class="col-4">
                                    <label for="users">TIPO</label>
                                    <select name="usuario-tipo-3" id="usuario-tipo-3" class="form-control">
                                        <option value="FÉRIAS">FÉRIAS</option>
                                        <option value="FOLGA">FOLGA</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="users">Usuário</label>
                                    <select name="usuarios-semana-3" class="form-control select2">
                                        <option value="">Selecione um Usuário</option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->rowid}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- SEMANA 4 --}}
                            <div class="row mt-3">
                                <div class="col-4">
                                    <label for="data">SEMANA/DIA/MÊS das Férias/Folga</label>
                                    <input type="text" name="semana4" class="form-control datarangepicker" value="" placeholder="Selecione uma data">
                                </div>
                                <div class="col-4">
                                    <label for="users">TIPO</label>
                                    <select name="usuario-tipo-4" id="usuario-tipo-4" class="form-control">
                                        <option value="FÉRIAS">FÉRIAS</option>
                                        <option value="FOLGA">FOLGA</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="users">Usuário</label>
                                    <select name="usuarios-semana-4" class="form-control select2">
                                        <option value="">Selecione um Usuário</option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->rowid}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- SALVAR DADOS --}}
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary mt-4">Salvar Dados</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-4 mt-4 pt-2">
                        <div class="alert alert-danger display" role="alert">
                            <h4 class="alert-heading pt-3">Avisos Importantes.</h4>
                            <hr />
                            <p>- Só pode ser adicionado um usuário por vez.</p>
                            <p>- <strong>Para selecionar um único dia, exemplo - 04/01/2020, deve-se clicar no dia duas vezes e depois clicar fora do datepicker.</strong></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    @endif

    <div class="row pt-5 mt-5">

    </div>


@endsection

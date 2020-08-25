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
            <li class="breadcrumb-item active" aria-current="page">Plantão</li>
        </ol>
    </nav>

    {{-- PLANTÕES A SEGUIR --}}
    <div class="row mt-3 mb-0">
        <div class="col-11 pt-2">
            <h3>Plantões a seguir</h3>
        </div>
    </div>

    <hr />

    {{-- PLANTÕES A SEGUIR LISTAGEM --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Semana do Plantão</th>
                            <th>Usuários alocados</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plantoes as $plantao)
                            <tr>
                                <td>{{ \App\Utils::converterDataParaPadraoBrasileiroSemHora($plantao->start_date)}} - {{ \App\Utils::converterDataParaPadraoBrasileiroSemHora($plantao->end_date)}}</td>
                                <td>

                                    @php
                                        $plantaoEquipe = \App\PlantaoEquipeUser::select('user_id')->where('plantao_equipe_id', $plantao->id)->get();
                                    @endphp

                                    @foreach($plantaoEquipe as $usuario)
                                        @php
                                            $user = \App\User::select('name')->where('rowid', $usuario->user_id)->first(['name'])->name;
                                        @endphp
                                            @if($loop->remaining > 0)
                                                {{$user}},
                                            @else
                                                {{$user}}
                                            @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- CADASTRAR PLANTÕES --}}
    <div class="row mb-0">
        <div class="col-11 pt-2">
            <h3>Plantão da Equipe</h3>
        </div>
        <div class="col-1 text-right">
            <button class="btn btn-sm btn-dark pb-2 d-none" id="minimize"><i class="fas fa-window-minimize" style="font-size: 12px"></i></button>
            <button class="btn btn-sm btn-dark no-border pt-2"  id="maxmize"><i class="far fa-window-maximize"></i></button>
        </div>
    </div>

    <hr />

    {{-- CADASTRAR PLANTÕES FORMULÁRIO --}}
    <div class="card pb-0 mb-0" id="cadastrar-plantao">
        <div class="card-body">

            <div class="row" id="adicionar-plantao">
                <div class="col-8">
                    <form action="{{route('salvar-plantao')}}" method="POST">
                        @csrf

                        {{-- SEMANA 1 --}}
                        <div class="row">
                            <div class="col-4">
                                <label for="data">Semana do Plantão</label>
                                <input type="text" name="semana1" class="form-control datarangepicker" value="" placeholder="Selecione uma data">
                            </div>
                            <div class="col-8">
                                <label for="users">Usuários</label>
                                <select name="usuarios-semana-1[]" class="form-control select2-multiple-personalizado" multiple>
                                    @foreach ($users as $user)
                                    <option value="{{$user->rowid}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- SEMANA 2 --}}
                        <div class="row mt-3">
                            <div class="col-4">
                                <label for="data">Semana do Plantão</label>
                                <input type="text" name="semana2" class="form-control datarangepicker" value="" placeholder="Selecione uma data">
                            </div>
                            <div class="col-8">
                                <label for="users">Usuários</label>
                                <select name="usuarios-semana-2[]" class="form-control select2-multiple-personalizado" multiple>
                                    @foreach ($users as $user)
                                    <option value="{{$user->rowid}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- SEMANA 3 --}}
                        <div class="row mt-3">
                            <div class="col-4">
                                <label for="data">Semana do Plantão</label>
                                <input type="text" name="semana3" class="form-control datarangepicker" value="" placeholder="Selecione uma data">
                            </div>
                            <div class="col-8">
                                <label for="users">Usuários</label>
                                <select name="usuarios-semana-3[]" class="form-control select2-multiple-personalizado" multiple>
                                    @foreach ($users as $user)
                                    <option value="{{$user->rowid}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- SEMANA 4 --}}
                        <div class="row mt-3">
                            <div class="col-4">
                                <label for="data">Semana do Plantão</label>
                                <input type="text" name="semana4" class="form-control datarangepicker" value="" placeholder="Selecione uma data">
                            </div>
                            <div class="col-8">
                                <label for="users">Usuários</label>
                                <select name="usuarios-semana-4[]" class="form-control select2-multiple-personalizado" multiple>
                                    @foreach ($users as $user)
                                    <option value="{{$user->rowid}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- SALVAR DADOS --}}
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-block btn-primary mt-4">Salvar Dados</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-4 mt-4 pt-2">
                    <div class="alert alert-danger display" role="alert">
                        <h4 class="alert-heading pt-3">Avisos Importantes.</h4>
                        <hr />
                        <p>- Não é possível deletar uma semana de plantão.</p>
                        <p>- Para retirar uma usuário de uma semana, basta edita-la e será renovado a listagem.</p>
                        <p>- Não é possível registrar semanas iguais, ou seja, se você tentar registrar a semana 17/08/2020 até 23/08/2020 e ele já existir, todos os dados antigos relacionados a ela serão apagados e um novo registro com os novos dados será criado.</p>
                      </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row pt-5 mt-5">

    </div>


@endsection

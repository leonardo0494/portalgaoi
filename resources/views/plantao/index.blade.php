@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Plantão</li>
        </ol>
    </nav>

    <div class="row mb-0">
        <div class="col-11 pt-2">
            <h3>Plantão da Equipe</h3>
        </div>
        <div class="col-1 text-right">
            <button class="btn btn-sm btn-dark pb-2" id="minimize"><i class="fas fa-window-minimize" style="font-size: 12px"></i></button>
            <button class="btn btn-sm btn-dark no-border pt-2 d-none"  id="maxmize"><i class="far fa-window-maximize"></i></button>
        </div>
    </div>

    <hr />

    <div class="card" id="cadastrar-plantao">
        <div class="card-body">
            <div class="row" id="adicionar-plantao">
                <div class="col-md-12">
                    <form action="{{route('salvar-plantao')}}" method="POST">
                        @csrf

                        {{-- SEMANA 1 --}}
                        <div class="row">
                            <div class="col-4">
                                <label for="data">Semana do Plantão</label>
                                <input type="text" name="plantao[]" class="form-control datarangepicker" placeholder="Selecione uma data">
                            </div>
                            <div class="col-8">
                                <label for="users">Usuários</label>
                                <select name="usuarios[[]]" class="form-control select2-multiple-personalizado" multiple>
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
                                <input type="text" name="plantao[]" class="form-control datarangepicker" placeholder="Selecione uma data">
                            </div>
                            <div class="col-8">
                                <label for="users">Usuários</label>
                                <select name="usuarios[[]]" class="form-control select2-multiple-personalizado" multiple>
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
                                <input type="text" name="plantao[]" class="form-control datarangepicker" placeholder="Selecione uma data">
                            </div>
                            <div class="col-8">
                                <label for="users">Usuários</label>
                                <select name="usuarios[[]]" class="form-control select2-multiple-personalizado" multiple>
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
                                <input type="text" name="plantao[]" class="form-control datarangepicker" placeholder="Selecione uma data">
                            </div>
                            <div class="col-8">
                                <label for="users">Usuários</label>
                                <select name="usuarios[[]]" class="form-control select2-multiple-personalizado" multiple>
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
            </div>
        </div>
    </div>



@endsection

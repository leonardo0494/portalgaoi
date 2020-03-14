@extends('layouts.app')

@section('content')

<div class="col-md-12">
    <div class="row">
        <h3>Próximas Atividades</h3>
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

<div class="col-md-12 border-bottom mb-3">
    <div class="row mb-1">
        <div class="col-md-10 pl-0 pt-2">
            <h3>Avisos</h3>
        </div>
        <div class="col-md-2 text-right p-0">
            <button type="button" class="btn btn-success" data-toggle='modal' data-target='#cadastrar-aviso'>Cadastrar Aviso</button>
        </div>
    </div>
</div>

<div class="col-md-12 mb-2">
    <div class="row">
        @if($notices->count() > 0)
            <div class="card-columns">
                @foreach($notices as $notice)
                    <div class="card">
                        <div class="card-header pb-0"><h5><strong>{{ mb_strtoupper($notice->title) }}</strong></h5></div>
                        <div class="card-body">
                            <p class="card-text text-justify">{!! $notice->description !!}</p>
                            <a href="{{route("close-notice", ["id" => $notice->rowid])}}" class="btn btn-primary">Concluir</a>
                        </div>
                        <div class="card-footer">
                            <p class="text-muted">{{\App\User::find($notice->user_id)->name}}<br>
                                @php
                                    $dataCriacao = explode(' ', $notice->created_at);
                                    $horaCriacao = explode(':', $dataCriacao[1]);
                                    $horaFormatada = $horaCriacao[0] . ":" . $horaCriacao[1];
                                @endphp
                                @if(date('Y-m-d') == $dataCriacao[0])
                                Hoje às {{ $horaFormatada }}.
                                @else
                                    Criado em {{ \App\Utils::converterDataParaPadraoBrasileiro($notice->created_at) }}.
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-mutted">Não há avisos...</p>
        @endif
    </div>
</div>

{{-- <div class="col-md-12 border-bottom mb-3">
    <div class="row">
        <h3>Plantão da Semana</h3>
    </div>
</div>

<div class="col-md-12">
    <div class="row">
        <div class="user-plantao">
            <img src="images/perfil-user.jpg">
            <p>Nome do Usuário</p>
        </div>
        <div class="user-plantao">
            <img src="images/perfil-user.jpg">
            <p>Nome do Usuário</p>
        </div>
        <div class="user-plantao">
            <img src="images/perfil-user.jpg">
            <p>Nome do Usuário</p>
        </div>
        <div class="user-plantao">
            <img src="images/perfil-user.jpg">
            <p>Nome do Usuário</p>
        </div>
    </div>
</div> --}}


{{-- MODAL DE CADASTRAR ATIVIDADES --}}
<div class="modal fade" id="cadastrar-aviso" tabindex="-1" role="dialog" arial-labelledby='cadastrar-aviso-label' aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('cadastrar-aviso')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastrar-aviso-label">Cadastrar Aviso</h5>
                    <button type="button" class="close" data-dismiss='modal' aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Título do Aviso</label>
                        <input type="text" name="title" id="title" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10" required></textarea>
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
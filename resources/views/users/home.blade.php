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

@if(Auth::user()->level_id == 1)
    <div class="col-md-12">
        <div class="row">
            <h3>Recursos com Atividade em Andamento</h3>
        </div>
        <div class="row">

        @if (count($recursosOcupados) == 0)
            <p class="text-muted">Não há atividades em andamento...</p>
        @else
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Recurso</th>
                        <th>Em atividade desde</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recursosOcupados as $recurso)
                        <tr>
                            <td>{{$recurso->recurso}}</td>
                            <td>{{$recurso->hora_inicio}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        </div>
    </div>
@endif

<div class="col-md-12">
    <div class="row">
        <h3>Próximas GMUDS</h3>
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
                        <td colspan="6" class='text-center'>Cadastre uma gmud para ela aparecer aqui :)</td>
                    </tr>
                @else
                    @foreach($atividades as $atividade)
                        <tr data-atividade="{{ $atividade->rowid }}">
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
                        <td colspan="6" class='text-center'>Não foram cadastradas gmuds para você ainda :)</td>
                    </tr>
                @else
                    @foreach($atividades as $atividade)
                        <tr data-atividade="{{ $atividade->rowid }}">
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
            <h3>Plantão da Semana</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="30%">Usuário</th>
                    <th>Telefone Trabalho</th>
                    <th>Telefone Pessoal</th>
                </tr>
            </thead>
            <tbody>
	    	@if (count($usuariosPlantao) > 0)
		    	@foreach ($usuariosPlantao as $usuario)
        	            <tr>
                	        <td>{{$usuario["name"]}}</td>
                        	<td>{{$usuario["work_phone"]}}</td>
	                        <td>{{$usuario["personal_phone"]}}</td>
        	            </tr>
                	@endforeach
		@else
			<tr>
				<td colspan='3' class='text-center'>Não foi registrado plantão para essa semana...</td>
			</tr>
		@endif
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12 border-bottom mb-3">
    <div class="row mb-1">
        <div class="col-md-10 pl-0 pt-2">
            <h3>Avisos</h3>
        </div>
    </div>
</div>

<div class="col-md-12 mb-2">
    <div class="row">
        <div class="col-md-12 text-right p-0">
            <button type="button" class="btn btn-success" data-toggle='modal' data-target='#cadastrar-aviso'>Cadastrar Aviso</button>
        </div>
    </div>
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

{{-- MODAL DADOS DA ATIVIDADE --}}
<div class="modal fade" id="dados-atividade" tabindex="1" role="dialog" arial-labelledby="dados-atividade-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title-activity">GMUD - 00009616635</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p><strong>Horário:</strong> <span id="hour-activity">23/03/2020 15:40 - 23/03/2020 18:00</span></p>
                <hr />
                <p>
                    <strong>Descrição:</strong><br>
                    <span id="body-activity">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Modi autem ab quaerat repudiandae cupiditate molestias commodi corrupti ut laudantium voluptate doloremque beatae ullam expedita, magni doloribus minus voluptatem dicta. Cum?
                    </span>
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary atualizar-atividade" data-tipo="concluir">Concluir Atividade</button>
              <button type="button" class="btn btn-secondary atualizar-atividade" data-tipo="cancelar">Cancelar Atividade</button>
            </div>
          </div>
    </div>
</div>

@endsection

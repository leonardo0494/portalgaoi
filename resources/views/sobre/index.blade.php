@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">Sobre</li>
    </ol>
</nav>
@include('flash-messages')

<div class="col-md-12 pb-4">
    <div class="row mb-3">
        <div class="col-6">
            <h3>Sobre</h3>
        </div>
        <div class="col-6 text-right pr-0">
            @if(Auth::user()->level_id == 1)
                <button type="button" class="btn btn-primary btn-sm" id="editar-sobre" >Editar Sobre</button>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="texto-renderizado">
            {!! $sobre->sobre !!}
        </div>

        <div class="col-md-12 d-none" id="editar-texto">
            <form action="{{route('salvar-sobre', ['id' => $sobre->id])}}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="sobre" id="description" cols="30" rows="10">{!! $sobre->sobre !!}</textarea>
                </div>
                <div class="form-group text-right">
                    <button type="button" class="btn btn-secondary" id="cancelar-edicao">Cancelar Ediçãor</button>
                    <button type="submit" class="btn btn-dark">Salvar Edição</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

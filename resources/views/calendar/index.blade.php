@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Calendário</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="datepicker" class="table-responsive" data-date="{{ date('d/m/Y') }}"></div>                
                <input type="hidden" id="data-selecionada">
            </div>
        </div>
    </div>

@endsection
@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">Sistemas</li>
    </ol>
</nav>

@include('flash-messages')

<div class="col-md-12 pb-4">
    <div class="row">
        <h3>Importação de Sistemas</h3>
    </div>
    <div class="row">
            <div class="col-md-12 px-0">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('salvar-sistema')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sistemas">Importação de Sistemas</label>
                                        <input type="file" name="sistemas" id="sistemas" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 pt-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-xl mt-4">Salvar Planilha</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection

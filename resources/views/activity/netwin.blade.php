@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Serviços Netwin</li>
        </ol>
    </nav>

    <div class="col-md-12">
    <div class="row mb-1">
        <div class="col-md-10 pl-0 pt-2">
            <h3>Serviços Netwin</h3>
        </div>
    </div>
    <div class="row">
	<div class="col-md-12">
		{!! str_replace("\n", "<br />", $resultado) !!}
	</div>
    </div>
</div>

@endsection

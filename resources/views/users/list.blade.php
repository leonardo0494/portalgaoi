@extends('layouts.app')

@section('content')
    
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">Usuários</li>
    </ol>
</nav>
<div class="col-md-12 pb-4">
    <div class="row">
        <h3>Usuários do Sistema</h3>
    </div>
    <div class="row">            
        <div class="table-responsive">
            <table class="table table-users table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone Trabalho</th>
                        <th>Telefone Pessoal</th>
                        <th>Login Oi</th>
                        <th>Login Remedy</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ ucwords(strtolower($usuario->name)) }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ ($usuario->work_phone != "") ? $usuario->work_phone : '-' }}</td>
                            <td>{{ ($usuario->personal_phone != "") ? $usuario->personal_phone : '-' }}</td>
                            <td>{{ ($usuario->login_oi != "") ? $usuario->login_oi : '-' }}</td>
                            <td>{{ ($usuario->login_remedy != "") ? $usuario->login_remedy : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
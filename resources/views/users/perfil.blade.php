@extends('layouts.app')

@section('content')
    
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">Perfil</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <h4 class="header-title mb-0">Informações Pessoais</h4>
    </div>
    <form action="{{route('editar-perfil')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <img src="{{  (\Auth::user()->profile_image == "") ?  asset('images/perfil-user.jpg') : asset( 'storage/imagens/' . \Auth::user()->profile_image . '') }}" class="img-thumbnail" />
                    <input type="file" name="profile_image" id="profile_image" hidden>
                    <button type="button" class="btn btn-success mt-2 show-form" id='upload-profile-image'>UPLOAD IMAGEM</button>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="font-weight-bold">Nome Completo</p>
                            <p>{{ \Auth::user()->name }}</p>     
                        </div>  
                        <div class="col-md-4">
                            <p class="font-weight-bold">E-mail</p>
                            <p>{{ \Auth::user()->email }}</p>         
                        </div>  
                        <div class="col-md-4">
                            <label for="work-phone" class="font-weight-bold">Telefone de Trabalho</label>
                            <p class="show-info">{{ (\Auth::user()->work_phone != "") ? \Auth::user()->work_phone : 'Não Informado' }}</p>
                            <input type="tel" name="work_phone" id="work-phone" class="form-control show-form" maxlength="15" value="{{\Auth::user()->work_phone}}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="personal-phone" class="font-weight-bold">Telefone Pessoal</label>
                            <p class="show-info">{{ (\Auth::user()->personal_phone != "") ? \Auth::user()->personal_phone : 'Não Informado' }}</p>
                            <input type="tel" name="personal_phone" id="personal-phone" class="form-control show-form" maxlength="15" value="{{\Auth::user()->personal_phone}}" />      
                        </div>  
                        <div class="col-md-4">
                            <label for="login-oi" class="font-weight-bold">Login Oi</label>
                            <p class="show-info">{{ (\Auth::user()->login_oi != "") ? \Auth::user()->login_oi : 'Não Informado' }}</p>
                            <input type="tel" name="login_oi" id="login_oi" class="form-control show-form" maxlength="13" value="{{\Auth::user()->login_oi}}" />       
                        </div>  
                        <div class="col-md-4">
                            <label for="login-remedy" class="font-weight-bold">Login Remedy</label>
                            <p class="show-info">{{ (\Auth::user()->login_remedy != "") ? \Auth::user()->login_remedy : 'Não Informado' }}</p>
                            <input type="tel" name="login_remedy" id="login-remedy" class="form-control show-form" maxlength="13" value="{{\Auth::user()->login_remedy}}" />
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 show-form">
                            <label for="password" class="font-weight-bold">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" id='cancelar-edicao' class="btn btn-secondary show-form">Cancelar</button>&nbsp; &nbsp;
            <button type="submit" class="btn btn-success show-form">Salvar Dados</button>
            <button type="button" id="editar-perfil" class="btn btn-primary show-info">Editar Perfil</button>
        </div>
    </form>
</div>
@endsection
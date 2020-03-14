<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Portal GA OI') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

    <style>

        body{
            background: #111111;
        }

        .wrapper-content{
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-login-portal{
            width: auto;
            height: auto;
            padding: 40px 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 5px 5px 0 back;
        }

        .title-form-login{
            text-align: center;
            font-size: 1.175em;
            margin-bottom: 40px;
            text-transform: uppercase;
            font-weight: bold;
        }

        input[type='email'], input[type='password']{
            width: 300px;
            border: none;
            background: #e8e8e8;
            padding: 10px 15px;
            color: #000;
        }

        input[type='email']:focus, input[type='password']:focus{
            border: none;            
            outline: none;
            border: 1px solid #ccc;
        }

        button{
            width: 100%;
            padding: 10px 0;
            background: #111111;
            border-radius: 3px;
            border: none;
            color: #FFF;
            text-transform: uppercase;
            color: #FFF;
            font-weight: bold;
            cursor: pointer;
        }

    </style>

</head>
<body>
    
    <div class="wrapper-content">
        <div class="form-login-portal">
            <h1 class="title-form-login">Iniciar Sessão no Portal</h1>
            <div class="container">
                <form method="POST" action="{{ route('authenticate') }}" class="form-signin">
                    @csrf
                    <div class="form-group">
                        <label for="Email"></label>
                        <input type="email" name="email" id="e-mail" placeholder="E-mail" required />
                    </div>
                    <div class="form-group">
                        <label for="Senha"></label>
                        <input type="password" name="password" id="password" placeholder="Password" required />
                    </div>
                    <div class="form-group text-center">
                        @if(session('error'))
                            <span class="invalid-feedback pb-3" style="display: block" role="alert">
                                <strong>{{ session('error') }}</strong>
                            </span>
                        @endif
                        <button type="submit">Iniciar Sessão</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
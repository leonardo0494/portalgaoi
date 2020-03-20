@component('mail::layout')

@slot('header')
    @component('mail::header', ['url' => config('app.url')]) {{$notice->titlte}} @endcomponent
@endslot
    
# Olá, pessoal!

Esse e-mail está sendo enviado para notificar a todos o registro de um novo aviso cadastrado por {{$user}}.

Segue os dados:

{!! $notice->description !!}

@slot('footer')
@component('mail::footer')
Não responda a esse e-mail, qualquer dúvida entrar em contato com o Gestor. 
@endcomponent
@endslot
@endcomponent
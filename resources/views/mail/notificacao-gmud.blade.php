@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
    Notificação GMUD
@endcomponent
@endslot
    
# Olá, {{$usuario['name']}}!

Você foi alocado para realizar a GMUD {{$gmud['ars_number']}} <br>
com início em {{$gmud['start_date']}}.

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
Não responda a esse e-mail, qualquer dúvida entrar em contato com o Gestor. 
@endcomponent
@endslot
@endcomponent
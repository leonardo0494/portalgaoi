@component('mail::message')
    
# Olá, {{$usuario['name']}}!

Você foi alocado para realizar a GMUD {{$gmud['ars_number']}} <br>
com início em {{$gmud['start_date']}}.

@endcomponent
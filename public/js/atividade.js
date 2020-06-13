inicializar();

/* BOTOES DE ACAO DA ATIVIDADE */
const INICIAR_ATIVIDADE = document.getElementById("iniciar-atividade");
const PARAR_ATIVIDADE   = document.getElementById("parar-atividade");

/* CAMPOS ATIVIDADE */

const TIPO_ATIVIDADE = document.getElementById("tipo");
const COD_ATIVIDADE  = document.getElementById("cod");
const ARS_ATIVIDADE  = document.getElementById('ars');
const SYS_ATIVIDADE  = document.getElementById('sys');
const HORA_INICIO    = document.getElementById('hora-inicio');
const HORA_FIM       = document.getElementById('hora-fim');
const HORA_INICIO_RL = document.getElementById('hora-inicio-real');
const HORA_FIM_RL    = document.getElementById('hora-fim-real');

let horaInicio = "";
let horaFim    = "";
atividadeIniciada = "";

INICIAR_ATIVIDADE.addEventListener('click', function(){
    
    let data = createDate();

    HORA_INICIO.value    = converterDataPadraoBrasileiro(data);
    HORA_INICIO_RL.value = data;

    localStorage.setItem('atividade', true);   
    localStorage.setItem('hora_inicio', data);
    
    iniciarAtividade();    

    document.getElementById("contador-atividade").classList.remove('d-none');
    INICIAR_ATIVIDADE.classList.add('d-none');
});

PARAR_ATIVIDADE.addEventListener('click', ()=>{
    fecharAtividade();
})

TIPO_ATIVIDADE.addEventListener('change', () => {

    COD_ATIVIDADE.classList.add('d-none');
    ARS_ATIVIDADE.classList.add('d-none');
    SYS_ATIVIDADE.classList.add('d-none');
    
    if(TIPO_ATIVIDADE.value == 'DEFEITO' || TIPO_ATIVIDADE.value == 'CALL'){
        COD_ATIVIDADE.classList.remove('d-none');
        SYS_ATIVIDADE.classList.remove('d-none');
        return true;
    }

    if(TIPO_ATIVIDADE.value == 'DEFEITO_ARS'){
        COD_ATIVIDADE.classList.remove('d-none');
        ARS_ATIVIDADE.classList.remove('d-none');
	SYS_ATIVIDADE.classList.remove('d-none');
        return true;
    }

    if(TIPO_ATIVIDADE.value == 'ARS'){
        ARS_ATIVIDADE.classList.remove('d-none');
        SYS_ATIVIDADE.classList.remove('d-none');
        return true;
    }

    if(TIPO_ATIVIDADE.value == 'MELHORIAS' || TIPO_ATIVIDADE.value == "MONITORAMENTO" || TIPO_ATIVIDADE.value == "TREINAMENTO"){
        SYS_ATIVIDADE.classList.remove('d-none');
        return true;
    }

    return true;

});

function createDate(){
    let data     = new Date();
    let ano      = data.getFullYear();
    let mes      = ( (data.getMonth() + 1) < 10 ) ? `0${data.getMonth() + 1}` : data.getMonth() + 1;
    let dia      = ( data.getDate() < 10 ) ? `0${data.getDate()}` : data.getDate();
    let hora     = (data.getHours() < 10) ? `0${data.getHours()}` : data.getHours();
    let minutos  = (data.getMinutes() < 10) ? `0${data.getMinutes()}` : data.getMinutes();
    let segundos = (data.getSeconds() < 10) ? `0${data.getSeconds()}` : data.getSeconds();
    return `${ano}-${mes}-${dia} ${hora}:${minutos}:${segundos}`
}

function converterDataPadraoBrasileiro(data){
    let dataFull = data.split('-');
    let horaSplite = dataFull[2].split(" ");
    return `${horaSplite[0]}/${dataFull[1]}/${dataFull[0]} ${horaSplite[1]}`;
}

function iniciarAtividade(hora = 00, minutos = 00, segundos = 00, sinalizarAtividade=true){

    if(sinalizarAtividade){
        document.getElementById("horasAtividade").innerHTML = '00:00:00'; 
        let ajaxReq = new XMLHttpRequest();
        ajaxReq.open('GET', '/atividade-online');
        ajaxReq.send();
    }

    atividadeIniciada = setInterval(()=>{
        if(localStorage.getItem('atividade') == 'true'){
            segundos +=1;
            if(segundos == 60){
                minutos += 1;
                segundos = 0;
                if(minutos == 60){
                    hora +=1;
                    minutos = 0;
                }
            }
            document.getElementById("horasAtividade").innerHTML = `${(hora < 10) ? '0' + hora : hora}:${(minutos < 10) ? '0' + minutos : minutos}:${(segundos < 10) ? '0' + segundos : segundos}`
            localStorage.setItem('time', `${(hora < 10) ? '0' + hora : hora}:${(minutos < 10) ? '0' + minutos : minutos}:${(segundos < 10) ? '0' + segundos : segundos}`);
        }
    }, 1000);
}

function fecharAtividade(){
    let data = createDate();
    HORA_FIM.value    = converterDataPadraoBrasileiro(data);
    HORA_FIM_RL.value = data;
    localStorage.clear();
    clearInterval(atividadeIniciada);
    sessionStorage.clear();    
    document.getElementById("contador-atividade").classList.add('d-none');
    INICIAR_ATIVIDADE.classList.remove('d-none');let 
    
    ajaxReq = new XMLHttpRequest();
    ajaxReq.open('GET', '/atividade-finalizada');
    ajaxReq.send();
}

function inicializar(){

    if(localStorage.getItem('time')){
        let time = localStorage.getItem('time').split(":");

        let hora     = parseInt(time[0]);
        let minutos  = parseInt(time[1]);
        let segundos = parseInt(time[2]);
        clearInterval(atividadeIniciada);
        iniciarAtividade(hora, minutos, segundos, false);
        document.getElementById('hora-inicio').value    = converterDataPadraoBrasileiro(localStorage.getItem('hora_inicio'));
        document.getElementById('hora-inicio-real').value = localStorage.getItem('hora_inicio');
        document.getElementById("horasAtividade").innerHTML = localStorage.getItem('time');
        document.getElementById("contador-atividade").classList.remove('d-none');
        document.getElementById("iniciar-atividade").classList.add('d-none');

    }

}

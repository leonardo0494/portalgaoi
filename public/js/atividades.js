$(document).ready(function(){
    
    inicializar();

    /* BOTOES DE ACAO DA ATIVIDADE */
    const INICIAR_ATIVIDADE = $("#iniciar-atividade");
    const PARAR_ATIVIDADE   = $("#parar-atividade");
    
    /* CAMPOS ATIVIDADE */
    
    const TIPO_ATIVIDADE = $("#tipo");
    const COD_ATIVIDADE  = $("#cod");
    const ARS_ATIVIDADE  = $("#ars");
    const SYS_ATIVIDADE  = $("#sys");
    const HORA_INICIO    = $("#hora-inicio");
    const HORA_FIM       = $("#hora-fim");
    const HORA_INICIO_RL = $("#hora-inicio-real");
    const HORA_FIM_RL    = $("#hora-fim-real");

    $(INICIAR_ATIVIDADE).click(function(){
      
        let data = createDate();

        $(HORA_INICIO).val(converterDataPadraoBrasileiro(data));
        $(HORA_INICIO_RL).val(data);

        localStorage.setItem('atividade', true);   
        localStorage.setItem('hora_inicio', data);
        
        //iniciarAtividade();    

        $.ajax({
            method: 'GET',
            url : '/atividade-online',
            data: {
                "hora_inicio" : data
            }
        }).done( response => {
            $("#id-atividade").val(response.id_atividade);
        })

        $("#contador-atividade").removeClass('d-none');
        $(INICIAR_ATIVIDADE).addClass('d-none');

    });

    $(PARAR_ATIVIDADE).click(function(){
        let data = createDate();
        fecharAtividade(data);
        $.ajax(
            {
                method: 'GET',
                url: '/atividade-finalizada',
                data: {
                    "hora_termino" : data
                }
            }
        );

    });

    $(TIPO_ATIVIDADE).change(function() {

        $(COD_ATIVIDADE).addClass('d-none');
        $(ARS_ATIVIDADE).addClass('d-none');
        $(SYS_ATIVIDADE).addClass('d-none');
        
        if(TIPO_ATIVIDADE.val() == 'DEFEITO' || TIPO_ATIVIDADE.val() == 'CALL'){
            $(COD_ATIVIDADE).removeClass('d-none');
            $(SYS_ATIVIDADE).removeClass('d-none');
            return true;
        }

        if(TIPO_ATIVIDADE.val() == 'DEFEITO_ARS'){
            $(COD_ATIVIDADE).removeClass('d-none');
            $(ARS_ATIVIDADE).removeClass('d-none');
            $(SYS_ATIVIDADE).removeClass('d-none');
            return true;
        }

        if(TIPO_ATIVIDADE.val() == 'ARS'){
            $(ARS_ATIVIDADE).removeClass('d-none');
            $(SYS_ATIVIDADE).removeClass('d-none');
            return true;
        }

        if(TIPO_ATIVIDADE.val() == 'MELHORIAS' || TIPO_ATIVIDADE.val() == "MONITORAMENTO" || TIPO_ATIVIDADE.val() == "TREINAMENTO"){
            $(SYS_ATIVIDADE).removeClass('d-none');
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
    
        if(sinalizarAtividade)
            document.getElementById("horasAtividade").innerHTML = '00:00:00'; 
    
        setInterval(()=>{
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
    
    function fecharAtividade(data){
        HORA_FIM.value    = converterDataPadraoBrasileiro(data);
        HORA_FIM_RL.value = data;
        localStorage.clear();
        clearInterval();
        sessionStorage.clear();    
        document.getElementById("contador-atividade").classList.add('d-none');
        INICIAR_ATIVIDADE.classList.remove('d-none');let 

        // ajaxReq = new XMLHttpRequest();
        // ajaxReq.open('GET', '/atividade-finalizada');
        // ajaxReq.send();
    }
    
    function inicializar(){
        
        $.ajax({
            method: 'GET',
            url : '/check-atividade'
        }).done( response => {
            if(response.existe == "finalizada"){
                $(INICIAR_ATIVIDADE).addClass('d-none');
                $("#fechar-atividade").removeClass('d-none');
            } else if (response.existe == "iniciada") {
                localStorage.setItem('atividade', true);   
                localStorage.setItem('hora_inicio', response.hora_inicio);
                $("#id-atividade").val(response.id_atividade);
                $("#iniciar-atividade").addClass('d-none');
                $("#contador-atividade").removeClass('d-none');
            }
        });

    }

});
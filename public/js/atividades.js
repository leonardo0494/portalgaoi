$(document).ready(function(){

    inicializar();

    /* BOTOES DE ACAO DA ATIVIDADE */
    const INICIAR_ATIVIDADE = $("#iniciar-atividade");
    const PARAR_ATIVIDADE   = $("#parar-atividade");

    /* CAMPOS ATIVIDADE */
    const HORA_INICIO        = $("#hora-inicio");
    const HORA_INICIO_RL = $("#hora-inicio-real");

    $(INICIAR_ATIVIDADE).click(function(){

        let data = createDate();

        let call = confirm("Você está entrando em uma call/reunião?");
        let objetivo = "";

        if(call) {
            objetivo = window.prompt("Informe o projeto, treinamento ou motivo?");

            if(!( objetivo != "" || objetivo != undefined))
                return false;
        }

        $(HORA_INICIO).val(converterDataPadraoBrasileiro(data));
        $(HORA_INICIO_RL).val(data);

        localStorage.setItem('atividade', true);
        localStorage.setItem('hora_inicio', data);

        //iniciarAtividade();

        $.ajax({
            method: 'GET',
            url : '/atividade-online',
            data: {
                "hora_inicio" : data,
                "call" : call,
                "objetivo" : objetivo
            }
        }).done( response => {
            $("#id-atividade").val(response.id_atividade);
        });

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

    /**
     * ACOES DE TABELA - LINHA DEFEITO
     */

     /**
      * ADICIONAR LINHA
      * */
     $("#add-line-def").click(function(){

        /**
         * Recuperar número de linhas na tabela
         */
        let proximaLinha = ($("#table-def-prj tbody tr").length) + 1;

        let linha = `
            <tr class="linha-${proximaLinha}">
                <td><input type="text" name="prj_ent[]" id="prj_ent" placeholder="Ex: PRJ0001234_ENT00004567" class="form-control" /></td>
                <td><input type="text" name="defeito[]" id="defeito" maxlength="4" placeholder="Ex: 765" class="form-control" /></td>
                <td class="text-center pt-3"><button type="button" class="btn btn-sm btn-md btn-danger" id="del-line-def" data-linha="${proximaLinha}"><i class="far fa-trash-alt"></i></button></td>
            </tr>
        `

        $("#table-def-prj tbody").append(linha);

     });

     /**
      * DELETAR LINHA
      * */
     $(document).on('click', '#del-line-def', function(){
        let linhaParaDeletar = $(this).data('linha');

        $(`#table-def-prj tbody tr.linha-${linhaParaDeletar}`).remove();

     });

});

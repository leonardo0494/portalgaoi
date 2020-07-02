$(document).ready(function(){

    inicializar();

    /* BOTOES DE ACAO DA ATIVIDADE */
    const INICIAR_ATIVIDADE = $("#iniciar-atividade");
    const PARAR_ATIVIDADE   = $("#parar-atividade");

    /* CAMPOS ATIVIDADE */

    const TIPO_ATIVIDADE = $("#tipo");
    const COD_ATIVIDADE  = $("#cod");
    const ARS_ATIVIDADE   = $("#ars");
    const SYS_ATIVIDADE    = $("#sys");
    const ARS_CATEGORIE  = $("#ars-cat");
    const ARS_DEF_CATEG = $("#def-ars");
    const DEFEITO_CATEG  = $("#cat-defeito");
    const HORA_INICIO        = $("#hora-inicio");
    const HORA_INICIO_RL = $("#hora-inicio-real");
    const SHOW_ARS             = $("#show_ars");
    const SHOW_ARS_DIV    = $("#show_ars_div");
    const SHOW_DEF             = $("#show_def");
    const SHOW_DEF_DIV    = $("#show_def_div");


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
        $(SHOW_ARS_DIV).addClass('d-none');
        $(SHOW_ARS).prop("checked", false);
        $(SHOW_DEF_DIV).addClass('d-none');
        $(SHOW_DEF).prop("checked", false);

        // COD -> PRJ e DEF
        // ARS -> ARS e PENDENCIA
        // SYS - SISTEMAS

        if(TIPO_ATIVIDADE.val() == 'DEFEITO'){
            $(COD_ATIVIDADE).removeClass('d-none');
            $(SYS_ATIVIDADE).removeClass('d-none');
            $(SHOW_ARS_DIV).removeClass('d-none');
            $(ARS_CATEGORIE).addClass('d-none');
            $(ARS_DEF_CATEG).addClass('d-none');
        }

        if(TIPO_ATIVIDADE.val() == 'CALL'){
            $(SHOW_ARS_DIV).removeClass('d-none');
            $(SHOW_DEF_DIV).removeClass('d-none');
        }

        if(TIPO_ATIVIDADE.val() == 'ARS'){
            $(DEF_CATEGORIE).addClass('d-none');
            $(ARS_DEF_CATEG).addClass('d-none');
            $(ARS_CATEGORIE).removeClass('d-none');
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

    $(SHOW_DEF).change(function(){

        if($(SHOW_DEF).is(":checked")){
            $(COD_ATIVIDADE).removeClass('d-none');

            if($(SHOW_ARS).is(":checked")){
                $(ARS_DEF_CATEG).removeClass('d-none');
                $(DEFEITO_CATEG).addClass('d-none');
            } else {
                $(ARS_DEF_CATEG).addClass('d-none');
                $(DEFEITO_CATEG).removeClass('d-none');
            }

        } else {
            $(COD_ATIVIDADE).addClass('d-none');
        }

    });

    $(SHOW_ARS).change(function(){

        if($(SHOW_ARS).is(":checked")){
            $(ARS_ATIVIDADE).removeClass('d-none');
            $(ARS_DEF_CATEG).removeClass('d-none');
            $(ARS_CATEGORIE).removeClass('d-none');
            $(ARS_DEF_CATEG).removeClass('d-none');
            $(DEFEITO_CATEG).addClass('d-none');
            $
        } else {
            $(ARS_ATIVIDADE).addClass('d-none');
            $(ARS_DEF_CATEG).addClass('d-none');
            $(ARS_CATEGORIE).addClass('d-none');
            $(ARS_DEF_CATEG).addClass('d-none');
            $(DEFEITO_CATEG).removeClass('d-none');
        }

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

     $(document).on('click', '#del-line-def', function(){
        let linhaParaDeletar = $(this).data('linha');

        $(`#table-def-prj tbody tr.linha-${linhaParaDeletar}`).remove();

     });

    /**
     * Detalhes da Tarefa
     */

    // $(".detalhe-report").click(function(){
    //     const idTarefa = $(this).data('id');

    //     let modalContent = `
    //         <p>
    //             <strong>Horário -</strong> <span id="hour-activity">23/03/2020 15:40 - 23/03/2020 18:00</span> <br>
    //             <strong>Tempo Total de Atividade: </strong> 00:15 <br>
    //             <strong>Tipo Atividade -</strong> Defeito <br>
    //             <strong>ARS: </strong> 12345678 <br>
    //             <strong>Sistema: </strong> SIEBEL
    //         </p>
    //         <hr />

    //         <strong>Defeitos: </strong>
    //         <ul>
    //             <li>1234 - PRJ0001211_ENT00012112</li>
    //             <li>1234 - PRJ0001211_ENT00012112</li>
    //         </ul>

    //         <p>
    //             <strong>Descrição:</strong><br>
    //             <span id="body-activity">

    //             </span>
    //         </p>
    //     `;

    //     $.ajax({
    //         method: "GET",
    //         url: "/detalhe-atividade",
    //         data: {
    //             id: idTarefa
    //         }
    //     }).done( response => {
    //         console.log(response);
    //     });

    // });

    // $.ajax({
    //     method: "GET",
    //     url: "/detalhe-atividade",
    //     data: {
    //         id: idTarefa
    //     }
    // }).done( response => {
    //     console.log(response);
    // });

});

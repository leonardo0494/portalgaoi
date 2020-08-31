$(document).ready(function() {

    $(".show-form").css('display', 'none');
    $(".show-info").css('display', 'block');

    $("#editar-perfil").click(function() {
        $(".show-form").css('display', 'block');
        $(".show-info").css('display', 'none');
    });

    $("#cancelar-edicao").click(function() {
        $(".show-form").css('display', 'none');
        $(".show-info").css('display', 'block');
    });

    $("#upload-profile-image").click(function() {
        $("#profile_image").click();
    });

    $(".table-users").DataTable({
        "autoWidth": false,
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            },
            "select": {
                "rows": {
                    "_": "Selecionado %d linhas",
                    "0": "Nenhuma linha selecionada",
                    "1": "Selecionado 1 linha"
                }
            }
        }
    });

    $(".dados-atividade").click(function() {
        let idAtividade = $(this).attr('data-atividade-id');
        $(".atualizar-atividade").attr('data-atividade-id', idAtividade);

        $.ajax({
            method: "get",
            url: "searchById",
            data: {
                id: idAtividade
            },
            success: function(response) {

                $("#title-activity").html(`${response.tipo} - ${response.numero_atividade}`);
                $("#hour-activity").html(`${response.data_inicio} - ${response.data_fim}`);
                if (response.status.toString() != 'ABERTO')
                    $('#modal-footer-acao').hide();

            }

        });

        $("#dados-atividade").modal('show');

    });

    $(".atualizar-atividade").click(function() {
        let tipoStatus = $(this).attr('data-tipo');
        let idAtividade = $(this).attr('data-atividade');

        if (confirm(`Você tem certeza que deseja ${tipoStatus.toUpperCase()} essa atividade?`)) {
            $.ajax({
                method: "GET",
                url: "atualizar-atividade",
                data: {
                    id: idAtividade,
                    tipo: tipoStatus
                },
                success: function(response) {
                    console.log(response);
                    let resp = response;
                    alert(`Atividade ${resp.toLowerCase()} com sucesso`);
                    location.reload();
                }
            })
        }

    });

    $(".cadastrar-atividade").click(function(){
        $(".cadastrar-action").removeClass('d-none');
        $(".editar-action").addClass('d-none');
    });

    $(".editar-atividade").click(function(){
        $(".cadastrar-action").addClass('d-none');
        $(".editar-action").removeClass('d-none');
        let idAtividade = $(this).attr('data-id-atividade');
        $('#id-atividade-editar').val(idAtividade);

        $.ajax({
            method: "get",
            url: "searchById",
            data: {
                id: idAtividade
            },
            success: function(response) {
                $("#ars_number").val(response.numero_atividade);
                $("#start_date").val(response.data_inicio);
                $("#end_date").val(response.data_fim);
                $("#user_id").val(response.executor);
            }
        }).done(function() {
            $("#carregando-info").html('');
        });

    });

    setTimeout(() => {
        $("#mensagem-atividade").animate(
            {
                opacity : 0
            },
            'slow',
            () => {
                $("#mensagem-atividade").attr('class', 'd-none');
            }
        )
    }, 1500);

    $(".data-mask").mask("00/00/0000");

    $("#data-range-inicio").datepicker({
        dateFormat: 'dd/mm/yy',
        closeText:"Fechar",
        prevText:"&#x3C;Anterior",
        nextText:"Próximo&#x3E;",
        currentText:"Hoje",
        monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
        monthNamesShort:["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
            dayNames:["Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","Sábado"],
            dayNamesShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
        dayNamesMin:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
        weekHeader:"Sm",
        firstDay:1
    });

    $("#data-range-fim").datepicker({
        dateFormat: 'dd/mm/yy',
        closeText:"Fechar",
        prevText:"&#x3C;Anterior",
        nextText:"Próximo&#x3E;",
        currentText:"Hoje",
        monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
        monthNamesShort:["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
            dayNames:["Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","Sábado"],
            dayNamesShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
        dayNamesMin:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
        weekHeader:"Sm",
        firstDay:1
    });

    const dataRangeInicio = $("#data-range-inicio");
    const dataRangeFim = $("#data-range-fim");

    $("#data-range-inicio").change(function(){

        let dataInicio = splitDate($(dataRangeInicio).val());
        let dataFim    = splitDate($(dataRangeFim).val());

        dataInicio = `${dataInicio[1]}/${dataInicio[0]}/${dataInicio[2]}`;
        dataFim    = `${dataFim[1]}/${dataFim[0]}/${dataFim[2]}`;

        let newDataInicio = new Date(dataInicio);
        let newDataFim    = new Date(dataFim);

        if ((newDataInicio.getTime() > newDataFim.getTime()) || (newDataInicio.getTime() == newDataFim.getTime())) {
            $("#data-range-fim").val('');
        }
    });

    $("#data-range-fim").change(function(){

        let dataInicio = splitDate($(dataRangeInicio).val());
        let dataFim    = splitDate($(dataRangeFim).val());

        dataInicio = `${dataInicio[1]}/${dataInicio[0]}/${dataInicio[2]}`;
        dataFim    = `${dataFim[1]}/${dataFim[0]}/${dataFim[2]}`;

        let newDataInicio = new Date(dataInicio);
        let newDataFim    = new Date(dataFim);

        if ((newDataInicio.getTime() > newDataFim.getTime()) || (newDataInicio.getTime() == newDataFim.getTime())) {
            $("#data-range-fim").val($(dataRangeFim).val());
            $("#data-range-fim").val('');
        }
    });

    function splitDate(data){
        return data.split('/');
    }

    // BUSCAR ARS

    $("#pesquisar-ars").click(function(e){
        e.preventDefault();
        let numeroArs = $("#pesquisar_numero_ars").val();
        let urlArs = `http://10.32.214.139/statusreport/chamado.php?ars=${numeroArs}`;
        window.open(urlArs, '_Blank');
        $("#pesquisar_numero_ars").val();
    });

});


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

    $("#tabela-atividades tbody tr").dblclick(function() {
        let idAtividade = $(this).attr('data-atividade');

        $(".atualizar-atividade").attr('data-atividade', idAtividade);

        $.ajax({
            method: "get",
            url: "searchById",
            data: {
                id: idAtividade
            },
            success: function(response) {
                $("#title-activity").html(`${response.tipo} - ${response.numero_atividade}`);
                $("#hour-activity").html(`${response.data_inicio} - ${response.data_fim}`);
                $("#body-activity").html(response.descricao);

                console.log(response.status);

                if (response.status != 'ABERTO')
                    $('.modal-footer').hide();

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
                    let resp = response;
                    alert(`Atividade ${resp.toLowerCase()} com sucesso`);
                    location.reload();
                }
            })
        }

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

    $("#detalhes-tarefa").click(function(){
        let reportId = $(this).data('id');
        $.ajax({
            method: 'get',
            url: 'detalhe-atividade',
            data: {
                id: reportId
            }
        }).done( response => {

            let html = "";

            html += `
                <h5 style="font-weight: bold">Tipo Atividade</h5>
                <p style="font-size: 14px;">${response.reports.tipo}</p>
            `;

            if(response.reports.tipo == "DEFEITO" || response.reports.tipo == "CALL" ){
                html += `
                    <h5 style="font-weight: bold">Defeitos</h5>
                    <table class="table">
                `;

                response.defeitos.forEach( defeito => {
                    html += `
                        <tr>
                            <td>${defeito.def}</td>
                            <td>${defeito.prj_ent}</td>
                        </tr>
                    `;
                });

                html += `</table>`;

                html += `
                    <h5 style="font-weight: bold">Sistema</h5>
                    <p style="font-size: 14px;">${response.reports.sistema}</p>
                `;

            }

            if(response.reports.tipo == "DEFEITO_ARS" ){

                html = `
                    <h5 style="font-weight: bold">Tipo Atividade</h5>
                    <p style="font-size: 14px;">DEFEITO + ARS</p>
                `;

                html += `
                    <h5 style="font-weight: bold">ARS</h5>
                    <p style="font-size: 14px;">${response.reports.ars ? response.reports.ars : '-'}</p>

                    <h5 style="font-weight: bold">Defeitos</h5>
                    <table class="table">
                `;

                response.defeitos.forEach( defeito => {
                    html += `
                        <tr>
                            <td>${defeito.def}</td>
                            <td>${defeito.prj_ent}</td>
                        </tr>
                    `;
                });

                html += `</table>`;

                html += `
                    <h5 style="font-weight: bold">Pendência</h5>
                    <p style="font-size: 14px;">${response.reports.pendencia}</p>
                `;

                html += `
                    <h5 style="font-weight: bold">Sistema</h5>
                    <p style="font-size: 14px;">${response.reports.sistema}</p>
                `;

            }

            if(response.reports.tipo == "ARS" ){
                html += `
                    <h5 style="font-weight: bold">ARS</h5>
                    <p style="font-size: 14px;">${response.reports.ars ? response.reports.ars : '-'}</p>
                `;

                html += `
                    <h5 style="font-weight: bold">Pendência</h5>
                    <p style="font-size: 14px;">${response.reports.pendencia}</p>
                `;

                html += `
                    <h5 style="font-weight: bold">Sistema</h5>
                    <p style="font-size: 14px;">${response.reports.sistema}</p>
                `;

            }

            if(response.reports.tipo== 'MELHORIAS' || response.reports.tipo== "MONITORAMENTO" || response.reports.tipo== "TREINAMENTO"){

                html += `
                    <h5 style="font-weight: bold">Sistema</h5>
                    <p style="font-size: 14px;">${response.reports.sistema}</p>
                `;

            }

            html += `
                <h5 style="font-weight: bold">Descrição</h5>
                <p style="font-size: 14px;">${response.reports.descricao}</p>
            `;

            $("#reportsDetails").html(html);

            console.log(response);
        })


    });

});

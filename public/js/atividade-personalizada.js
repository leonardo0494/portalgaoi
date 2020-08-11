$(document).ready(function(){

    // RESETS FUNCTION

    function resets(){
        
        // VARIAVEIS
        let arsShw = $("#show_ars");
        let arsOpc  = $("#ars-opc");
        let arsDiv   = $("#ars");
        let defShw = $("#show_defeito");
        let defOpc = $("#def-opc");
        let defDiv  = $("#defeito");
        let sisDiv    = $("#sistema");

        // UNCHECK CHECKBOXES

        $(arsShw).prop("checked", false);
        $(defShw).prop("checked", false);

        // HIDE FORM FIELDS

        if( !(arsDiv).hasClass('d-none') )
            (arsDiv).addClass('d-none');

        if(!(defDiv).hasClass('d-none'))
            (defDiv).addClass('d-none')

        if(!(sisDiv).hasClass('d-none'))
            (sisDiv).addClass('d-none');

        if(!(arsOpc).hasClass('d-none'))
            (arsOpc).addClass('d-none');

        if(!(defOpc).hasClass('d-none'))
            (defOpc).addClass('d-none');

	// RESETAR CAMPO ATIVIDADES
	$("#campo-descricao").attr("maxlength", 50);
        $("#campo-descricao").attr("placeholder", "Limite de 50 caracteres...");
	$("#texto-descricao").html("Descrição");

    }

    $("#tipo-atividade").change(function(){

        // VARIAVEIS
        let tipo = $(this).val();
        
        // RESETS
        resets();

        // DEFEITO 

        if(tipo == "DEFEITO"){
            $("#ars-opc").removeClass('d-none');
            $("#defeito").removeClass('d-none');
            $("#sistema").removeClass('d-none');
        }

        // ARS

        if(tipo == "ARS"){
            $("#ars").removeClass('d-none');
            $("#sistema").removeClass('d-none');
        }

        // CALL

        if(tipo == "CALL"){
            $("#ars-opc").removeClass('d-none');
            $("#def-opc").removeClass('d-none');
        }

        let comuns = ['MELHORIAS', 'MONITORAMENTO', 'TREINAMENTO', 'REUNIÃO'];        

        if(comuns.indexOf(tipo) > -1){
            $("#sistema").removeClass('d-none');
        }

    });

    $("#show_ars").change(function() {

        let showARs = $(this);

        if( (showARs).is(":checked")){
            $("#ars").removeClass('d-none');
        } else {
            $("#ars").addClass('d-none');
        }

        if($("#tipo-atividade").val() == "CALL"){
            $("#sistema").removeClass('d-none');
        }

    });

    $(".pendencia").change(function() {
	
	let valor = $(this).val();
	
	if(valor == "SIM") {
		$("#campo-descricao").attr("maxlength", 250);
		$("#campo-descricao").attr("placeholder", "Limite de 250 caracteres...");
		$("#texto-descricao").html("Escreva sua história triste");
	} else {
		$("#campo-descricao").attr("maxlength", 50);
		$("#campo-descricao").attr("placeholder", "Limite de 50 caracteres...");
		$("#texto-descricao").html("Descrição");
	}

    });

    $("#show_defeito").change(function() {

        let showDefeito = $(this);

        if( (showDefeito).is(":checked")){
            $("#defeito").removeClass('d-none');
        } else {
            $("#defeito").addClass('d-none');
        }

        if($("#tipo-atividade").val() == "CALL"){
            $("#sistema").removeClass('d-none');
        }

    });

});

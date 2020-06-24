$(document).ready(function() {

    $("#editar-sobre").click(function(){
        $(this).addClass('d-none');
        $("#texto-renderizado").addClass('d-none');
        $("#editar-texto").removeClass('d-none');
    });

    $("#cancelar-edicao").click(function(){
        $("#editar-texto").addClass('d-none');
        $("#texto-renderizado").removeClass('d-none');
        $("#editar-sobre").removeClass('d-none');
    });

});

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

});
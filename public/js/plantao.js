$(document).ready(function() {

    $("#cadastrar-plantao").hide();

    $("#minimize").click(function() {
        $("#cadastrar-plantao").animate({height: '10px', opacity: '0'}, "slow", function(){
            $("#cadastrar-plantao").hide();
        });
        $(this).addClass('d-none');
        $("#maxmize").removeClass('d-none');
    });

    $("#maxmize").click(function() {
        $("#cadastrar-plantao").animate({height: '424px', opacity: '1'}, "slow");
        $("#cadastrar-plantao").show();
        $(this).addClass('d-none');
        $("#minimize").removeClass('d-none');
    });

});

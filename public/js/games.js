$(document).ready(function ()
{
    $(".js--game").click(function (e)
    {
        e.preventDefault();
        let game = $(this).attr("data-id");

        $(".version").hide();
        $(".version[data-game='" + game + "']").css("display", "block");

        $(".js--game-name").html(game);
        $('.versions').show();
        $(".games").hide();

    });

    $(".js--game-list").click(function (e)
    {
        e.preventDefault();
        $('.versions').hide();
        $(".games").show();
    });

    $(".js--version").click(function (e)
    {
        e.preventDefault();
    });
})
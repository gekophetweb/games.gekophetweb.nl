$(document).ready(function ()
{
    $(".js--refresh-background").click(function (e)
    {
        e.preventDefault();

        let backgroundId    = Math.ceil(Math.random() * 11);
        let backgroundClass = backgroundId < 10 ? "background-0" : "background-";

        $("body").attr("class", backgroundClass + backgroundId);

    });
})
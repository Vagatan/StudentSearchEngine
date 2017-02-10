$(document).ready(function () {
    var clearSessionUrl = $("#clear_session_link").data("href");
    var clearButton = $(".clear_session");
    clearButton.click(function (event){
        $.ajax({
            type:"POST",
            url: clearSessionUrl
        });
    });
});


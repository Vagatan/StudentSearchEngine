$(document).ready(function () {
    var clearButton = $(".clear_session");
    clearButton.click(function (event){
        $.ajax({
            type:"POST",
            url: window.location.href + "/cleartest"
        });
    });
});


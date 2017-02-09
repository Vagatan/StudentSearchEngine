$(document).ready(function () {
    var storageButton = $(".add_to_storage");
    storageButton.click(function (event){
        var studentId = $(event.target).attr("id");
        $(event.target).prop("disabled", true);
        console.log("dupa");
        $.ajax({
            type:"POST",
            url: "addToStorage",
            data: {'studentId' : studentId}
        });
    });
});
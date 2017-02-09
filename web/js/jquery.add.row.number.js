var addRowNumber = function () {
    var i = 1;
    $('table tbody tr').each(function(index) {
        $(this).find('td:nth-child(1)').html(index+1);
    });
};

addRowNumber();


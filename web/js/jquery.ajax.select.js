$(document).ready(function () {
    var form = $("form[name=student]");
    var district = $("#student_district");
    form.on("change", "#student_district", function (e) {
        var $data = {"district_id": district.val()};
        $.ajax({
            type: "POST",
            data: $data,
            url: "county"
        }).done(function (counties) {
            console.log('dc');
            $("#student_community option").remove();
            $("#student_county option").remove();
            var selectedCommunity = $("#student_community");
            selectedCommunity.append($("<option>").attr("value", "").text("Wybierz gminę"));
            var county = $("#student_county");
            county.append($("<option>").attr("value", "").text("Wybierz powiat"));
            $(counties.counties).each(function (i, v) {
                county.append($("<option>").attr("value", v.id).text(v.name));
            });
        });
    });
    form.on("change", "#student_county", function (e) {
        var $countyData = {"county_id": $("#student_county").val()};
        $.ajax({
            type: "POST",
            data: $countyData,
            url: "community"
        }).done(function (community) {
            $("#student_community option").remove();
            var selectedCommunity = $("#student_community");
            selectedCommunity.append($("<option>").attr("value", "").text("Wybierz gminę"));
            $(community.community).each(function (i, v) {
                selectedCommunity.append($("<option>").attr("value", v.id).text(v.name));
            });
        });
    });

});
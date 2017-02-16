$(document).ready(function() {
    var url = getApiAddress() + "/recommend";
    $.ajax({
        type: "GET",
        dataType: "json",
        url: url,
        success: function(data) {
            var tables = document.getElementById("recommend-list");
            $.each(data, function(i, item) {
                var tpl  = "<a href='list.html?keyword={0}&page=1&order='><span>{1}</span></a>"
                var str = String.format(tpl,item.Name,item.Name)
                $("#recommend-list").append(str);
            });
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(textStatus, xhr);
            $("#recommend-list").hide()
        }
    });
})

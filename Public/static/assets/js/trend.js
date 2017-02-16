$(document).ready(function() {
    var url = getApiAddress() + "/trend";
    $.ajax({
        type: "GET",
        dataType: "json",
        url: url,
        success: function(data) {
            var tables = document.getElementById("trend-list");
            $.each(data, function(i, item) {
                var tpl = "<a target='_blank' href='detail.html?id={0}'>{1}</a>"
                var name =  String.format(tpl,item.ID,item.Name)
                var str = "<tr>"
                str += "<td>" + (i+1) + "</td>"
                str += "<td>" + name + "</td>"
                str += "<td>" + item.Heat + "</td>"
                str += "<td>" + getSize(item.Length) + "</td>"
                str += "<td>" + item.CreateTime.substring(0, 10) + "</td>"
                str += "</tr>"
                $("#trend-list").append(str);
            });
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(textStatus, xhr);
            $("#recommend-list").hide()
        }
    });
})

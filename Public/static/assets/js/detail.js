$(document).ready(function() {
    var url = getApiAddress() + "/detail" + location.search;
    console.log(url);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: url,
        success: function(item) {
          $("#title").text(item.Name);
          $("#title").attr("href","magnet:?xt=urn:btih:"+item.Infohash);
          $("#btnCopy").attr("data-clipboard-text","magnet:?xt=urn:btih:"+item.Infohash);
          $("#magnet").text("magnet:?xt=urn:btih:"+item.Infohash);
          $("#magnet").attr("href","magnet:?xt=urn:btih:"+item.Infohash);
          $("#download").attr("href","magnet:?xt=urn:btih:"+item.Infohash);
          $("#length").text(getSize(item.Length));
          $("#file-count").text(item.FileCount);
          $("#create-time").text(item.CreateTime.substring(0,10));
          $("#download-num").text(99);
          var list = document.getElementById("file-list");
          list.innerHTML = "";
          $.each(item.Files, function(i, file) {
            var str = "";
            str += "<li>"+ file.Name+" ("+getSize(file.Length) +")</li>"
            $("#file-list").append(str);
          });
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(textStatus, xhr);
        }
    });
})


function copyLink(id){

}

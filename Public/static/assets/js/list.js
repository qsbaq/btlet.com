//$(document).ready(function(){
////    $("#pre-page").hide();
////    $("#next-page").hide();
////
////    var url = getApiAddress() + "/list" + location.search;
////    page = getUrlParameter("page")
////    if (page == 0) {
////        page = 1
////    }
//
//    setMenu()
//
////    $.ajax({
////        type: "GET",
////        dataType: "json",
////        url: url,
////        success: function(data) {
////            if (data.Count === 0) {
////                window.location.href = "404.html"
////            }
////            if (data.Torrent.length == 0) {
////                window.location.href = "404.html"
////            }
////            var tables = document.getElementById("list-panel");
////            $("#search-count").text("搜索到 " + spilitNum(data.Count.toString()) + " 个相关BT资源")
////            $.each(data.Torrent, function(i, item) {
////                var str = "<p>";
////                title = "<a href='detail.html?id={0}' class='result-title'><h5>{1}</h5></a>"
////                str += String.format(title, item.Infohash, item.Name)
////                if (item.Files.length > 0) {
////                    // str += "<p>" + item.Files[0].Name + "</p>"
////                }
////                str += "文件大小:<span class='listinfo'>" + getSize(item.Length) + "</span>"
////                str += "下载热度:<span class='listinfo'>" + item.Heat + "</span>"
////                str += "文件数:<span class='listinfo'>" + item.FileCount + "</span>"
////                str += "创建时间:<span class='listinfo'>" + item.CreateTime.substring(0, 10) + "</span>"
////                str += "</p></br>"
////                $("#list-panel").append(str);
////            });
//
////            num = Math.ceil(data.Count / 20)
////            if (num > 10) {
////                num = 10
////            }
////            for (var i = 1; i <= num; i++) {
////                var tpl = "<li><a href='search.php{0}'>{1}</a></li>"
////                if (i == page) {
////                    tpl = "<li class='active'><a href='search.php{0}'>{1}</a></li>"
////                }
////                str = String.format(tpl, location.search.replace("page=" + page, "page=" + i), i)
////                $("#next-page-li").before(str);
////            }
////            if (page > 1) {
////                $("#pre-page").show();
////                var tpl = "search.php{0}"
////                $("#pre-page").attr("href", location.search.replace("page=" + page, "page=" + (page - 1)))
////            }
////            if (page < num) {
////                $("#next-page").show();
////                var tpl = "search.php{0}"
////                next = parseInt(page, 10) + 1
////                $("#next-page").attr("href", location.search.replace("page=" + page, "page=" + next))
////            }
////        },
////        error: function(xhr, textStatus, errorThrown) {
////            console.log(textStatus, xhr);
////        }
////    });
//})
//
//
//
//function setMenu() {
//    order = getUrlParameter("order")
//    switch (order) {
//        case "":
//            $("#order-x").attr("class", "selected")
//            break;
//            // case "h":
//            // $("#order-h").attr("class", "selected")
//            break;
//        case "l":
//            $("#order-l").attr("class", "selected")
//            break;
//        case "h":
//            $("#order-h").attr("class", "selected")
//            break;
//        case "m":
//            $("#order-m").attr("class", "selected")
//            break;
//        default:
//    }
//
//    var current = "order=" + order
//    $("#order-x").attr("href", "search.php" + location.search.replace(current, "order="))
//        // $("#order-h").attr("href", "search.php"+location.search.replace(current,"order=h"))
//    $("#order-l").attr("href", "search.php" + location.search.replace(current, "order=l"))
//    $("#order-m").attr("href", "search.php" + location.search.replace(current, "order=m"))
//    $("#order-h").attr("href", "search.php" + location.search.replace(current, "order=h"))
//}
//
//function spilitNum(num) {
//    var result = "";
//    for (var i = 0; i < num.length; i++) {
//        if ((i-1>0) && (i%3==0)) {
//          result=","+result
//        }
//        result =num[num.length-i-1] + result
//    }
//    return result
//}

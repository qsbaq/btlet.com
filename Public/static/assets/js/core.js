//function getApiAddress(){
//  return "http://btmoster.com:8088"
//  //return "http://api.btlike.com"
//}


//function onSearch(id, page, order) {
//
//    var keyword = $(id).val();
//    console.log(keyword,1);
//    if (keyword === "") {
//        return
//    }
//    console.log("list.php?keyword=" + keyword + "&page=" + page + "&order=" + order);
//    window.location.href = "list.php?keyword=" + keyword + "&page=" + page + "&order=" + order
//}

function getSize(size) {
    if (size > 1024 * 1024 * 1024) {
        return (size / 1024 / 1024 / 1024).toFixed(2) + "GB"
    }
    if (size > 1024 * 1024) {
        return (size / 1024 / 1024).toFixed(2) + "MB"
    }
    if (size > 1024) {
        return (size / 1024).toFixed(2) + "KB"
    }
    return size.toFixed(2) + "Byte"
}




$('#search').keydown(function (e){
  console.log('Enter was pressed');
    if(e.keyCode == 13){
        console.log('Enter was pressed');
    }
})

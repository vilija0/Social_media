
var com;
function post_comments(el){
  let id = el.getAttribute("data-post-id");
  com = id;
  read(com);
}

function comments(){
    var idd = com;
    var post = document.getElementById("comments33").value;
    
        if(post == ""){
          alert("Polje mora biti popunjeno")
          
        }else{
          const xmlhttp = new XMLHttpRequest();

          xmlhttp.onload = function () {
              let id = idd;      
          }
          xmlhttp.open("GET", "comments.php?id=" + idd + "&post=" + post);
          xmlhttp.send();
          document.getElementById("comments33").value = "";
          read(idd)
    }
}

function read(a){

  const xmlhttp = new XMLHttpRequest();
  var  idd2 = a;
xmlhttp.onload = function () {
      document.getElementById("post_comments222").innerHTML = this.responseText;
}

xmlhttp.open("GET", "read_com.php?id=" + idd2);
xmlhttp.send();

}
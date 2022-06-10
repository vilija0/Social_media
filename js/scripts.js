function like_post(el) {
    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function () {
        let id = el.getAttribute('data-post-id');
        document.getElementById('likes_' + id).innerText = this.responseText;
        
        //document.getElementById("like" + id).style.display = "none";
        //document.getElementById("unlike" + id).style.display = "inline-block";
    }
    
    xmlhttp.open("GET", "like_post.php?id=" + el.getAttribute('data-post-id'));
    xmlhttp.send();
    location.reload(true);
}

function unlike_post(el) {
    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function () {
        let id = el.getAttribute('data-post-id');
        document.getElementById('likes_' + id).innerText = this.responseText;
        

        //document.getElementById("like" + id).style.display = "inline-block";
        //document.getElementById("unlike" + id).style.display = "none";
        
    }
    
    xmlhttp.open("GET", "unlike_post.php?id=" + el.getAttribute('data-post-id'));
    xmlhttp.send();
    location.reload(true);
}

function who_like(el){
    const xmlhttp = new XMLHttpRequest();
  xmlhttp.onload = function () {
      let id = el.getAttribute('data-post-id');
      document.getElementById('who').innerHTML = this.responseText;
  }
  xmlhttp.open("GET", "who_like.php?id=" + el.getAttribute('data-post-id'));
  xmlhttp.send();
  
}

function delete_post(el){
    let potvrda= confirm("Da li ste sigurni da zelite da obrisete post?");
    if(potvrda){
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function(){
        }
        xmlhttp.open("GET", "delete_post.php?id=" + el.getAttribute("data-post-id"));
        xmlhttp.send();
        location.reload(true);
    }
}delete_com

function delete_com(el){
    let potvrda= confirm("Da li ste sigurni da zelite da obrisete komentar?");
    if(potvrda){
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function(){
        }
        xmlhttp.open("GET", "delete_kom.php?id=" + el.getAttribute("data-post-id"));
        xmlhttp.send();
        location.reload(true);
    }
}


/*function like_post(el) {
    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function () {
        let id = el.getAttribute('data-post_id');
        document.getElementById('likes_' + id).innerText = this.responseText;

        el.setAttribute('disabled', 'disabled');

        setCookie("liked", el.getAttribute('data-post_id'), 9999999);
    }

    xmlhttp.open("GET", "functions/like.php?post_id=" + el.getAttribute('data-post_id'));
    xmlhttp.send();
}

if(getCookie("liked") !== "") {
    document.querySelector('button[data-post_id="'+getCookie("liked")+'"]').setAttribute('disabled', 'disabled');
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}*/
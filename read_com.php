<?php

include 'functions/init.php';
$id = $_GET['id'];
$user = get_user();
$mynames = $user['username'];

$sql = "SELECT * FROM comments WHERE post_id = '$id'";

$result = query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
       if($row['username'] == $mynames){
        $usr = $row['username'];
        $sql22 = "SELECT * FROM users WHERE username = '$usr'";
        $result22 = query($sql22);
        if($result22->num_rows > 0){ 
         
  while($row22 = $result22->fetch_assoc()){
    echo "
        
    <div class='container_cards'>
    <ul> 
    <li style='display:inline-block;' ><img style='border:solid 3px #222;border-radius:50%;' width='50px' src='".$row22['profile_image']."' alt=''>" . "     ". $row22['first_name']."
    " . "          " ."<button onclick='delete_com(this)' class='btn btn-danger' data-post-id='". $row['com_id'] ."' style='height: 27px; width: 121px;font-size: small; color:'red';'><i class='fas fa-trash-alt'>Obrisi komentar</i></button></li><br> 
    <li style='display:inline-block; margin-left: 45px' > <p>".$row['comment']."</p> </li>
    </ul>
    </div>
            ";
  }
        }
       }else{
        $usr = $row['username'];
        $sql2 = "SELECT * FROM users WHERE username = '$usr'";
        $result2 = query($sql2);
        if($result2->num_rows > 0){ 
            
  while($row2 = $result2->fetch_assoc()){
    echo "
        
    <div class='container'>
    <ul>
    <li style='display:inline-block;' ><a href='user_profil.php?username=".$row['username']."' ></a></li>
    <li style='display:inline-block;' > <p>".$row['comment']."</p> </li>
     </ul>
    </div>

    ";  }
      }
    }
  }
}else{
    echo "Jos nema komentara, komentarisi prvi";
}

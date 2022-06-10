<?php
include "functions/init.php";

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id = '$id'";
$result = query($sql);
if($result->num_rows>0){
    $row = $result->fetch_assoc();
    $likes = $row['likes'];
    $likes -= 1 ;
}
$sql = "UPDATE posts SET likes='$likes' WHERE id = '$id'";
confirm(query($sql));


$nameuser = get_user();
$myname = $nameuser['first_name'];

$sql = "DELETE FROM likes WHERE name = '$myname' AND post_id = '$id'";

confirm(query($sql));
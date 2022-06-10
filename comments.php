<?php
include 'functions/init.php';


$idd = $_GET['id'];
$post=  $_GET['post'];
$user = get_user();
$myname = $user['username'];


$sql = "INSERT INTO comments (username,post_id,comment) VALUES ('$myname','$idd','$post')";
confirm(query($sql));

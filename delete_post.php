<?php

include "functions/init.php";

$post_id = $_GET['id'];

$sql = "DELETE FROM posts WHERE id = '$post_id'";
confirm(query($sql));

$sql2 = "DELETE FROM likes WHERE post_id= '$post_id'";
confirm(query($sql2));

$sql3 = "DELETE FROM comments WHERE post_id= '$post_id'";
confirm(query($sql3));
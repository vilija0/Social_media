
<?php
include "functions/init.php";

$com_id = $_GET['id'];


$sql3 = "DELETE FROM comments WHERE com_id= '$com_id'";
confirm(query($sql3));

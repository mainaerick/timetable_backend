<?php 
include 'process/connect.php';

$length="";
for($i=1; $i<=70; $i++){
    $activation = md5(uniqid(rand(), true));
    $key = hash("joaat",uniqid(mt_rand(),true));
    $db->query("update department set u_key='$key' where id=$i;");

    // echo "The number is " . $key . "<br>";
    
}


?>
<?php
$db=new mysqli('localhost','root','','Timetable');
if($db->connect_errno){
    die("sorry server error");
}

?>
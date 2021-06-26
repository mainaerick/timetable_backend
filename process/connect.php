<?php
$db=new mysqli('localhost','root','','Timetable');
// $db->set_charset("utf8");
if($db->connect_errno){
    die("sorry server error");
}

?>
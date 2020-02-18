<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();


// include db connect class
include '../process/process.php';

// connecting to db


// get all products from products table

// if (isset($_POST['name'])) {
    
    $name = $_POST['name'];
    $db->query("insert into courses values('',
        '$name',
        '$name');") or die($db->error);
    // echo name;
// }

?>

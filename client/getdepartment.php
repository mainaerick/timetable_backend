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
$result = $db->query("SELECT * FROM department ORDER BY name ASC") or die(mysql_error());

// check for empty result
if($result->num_rows) {
    // looping through all results
    // products node
    $response["department"] = array();
    
   while($row=$result->fetch_assoc()) {
        // temp user array
        $department_client = array();
        $department_client["id"] = $row["id"];
        $department_client["dname"] = $row["name"];
       




        // push single product into final response array
        array_push($response["department"], $department_client);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No Departments found";

    // echo no users JSON
    echo json_encode($response);
}
?>

<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();


// include db connect class
include '../process/process.php';


// get all products from products table
// $cname=$_SESSION['getcoursename'];
$name = $_POST['name'];
$result = $db->query("SELECT * FROM courses where department='$name' ORDER BY `course_name` ASC") or die(mysql_error());

// check for empty result
if($result->num_rows) {
    // looping through all results
    // products node
    $response["course"] = array();
    
   while($row=$result->fetch_assoc()) {
        // temp user array
        $course_client = array();
        $course_client["id"] = $row["id"];
        $course_client["cname"] = $row["course_name"];
       




        // push single product into final response array
        array_push($response["course"], $course_client);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No courses found";

    // echo no users JSON
    echo json_encode($response);
}
?>

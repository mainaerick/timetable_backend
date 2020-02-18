<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();


// include db connect class
include '../process/process.php';

// post data from post
// $login_dep = $_POST['login_department'];
// $login_course=$_POST['login_course'];
// $login_year=$_POST['login_year'];
// $login_sem=$_POST['login_sem'];

// get all products from products table
$result = $db->query("SELECT * FROM lesson where fragment='monday'") or die(mysql_error());

// check for empty result
if($result->num_rows) {
    // looping through all results
    // products node
    $response["lessons"] = array();
    
   while($row=$result->fetch_assoc()) {
        // temp user array
        $product = array();
        $product["id"] = $row["id"];
        $product["lname"] = $row["lesson_name"];
        $product["frag"] = $row["fragment"];
        $product["lect"] = $row["lecturer"];
        $product["room"] = $row["room"];
        $product["fromtime"] = $row["from_time"];
        $product["totime"] = $row["to_time"];




        // push single product into final response array
        array_push($response["lessons"], $product);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No products found";

    // echo no users JSON
    echo json_encode($response);
}

// localhost:5000/locations 
// {
//     [
//         {
//             id  : 32423543,
//             long : 34.3434,
//             lat : 34.3244354
//         },
//         {
//             id : 234234,
//             long : 3434,
//             lat:43534545
//         }
//     ]
// }
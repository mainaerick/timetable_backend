<?php


$response = array();


// include db connect class
include '../process/process.php';

// post data from post
$login_dep = $_POST['login_department'];
$login_course=$_POST['login_course'];
$login_year=$_POST['login_year'];
$login_sem=$_POST['login_sem'];

// get all products from products table
$result = $db->query("SELECT * FROM exam where department='$login_dep'
and course='$login_course' and year_of_study='$login_year' and semester='$login_sem'") or die(mysql_error());


// check for empty result
if($result->num_rows) {
    // looping through all results
    // products node
    $response["exams"] = array();
    
   while($row=$result->fetch_assoc()) {
        // temp user array
        $exam = array();
        $exam["id"] = $row["id"];
        $exam["e_name"] = $row["name"];
        $exam["e_date"] = $row["date"];
        $exam["from_time"] = $row["from_time"];
        $exam["to_time"] = $row["to_time"];
        $exam["room"] = $row["room"];
        $exam["code"] = $row["code"];



        // push single product into final response array
        array_push($response["exams"], $exam);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No Exams found";

    // echo no users JSON
    echo json_encode($response);
}

?>
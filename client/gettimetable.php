<?php
include '../process/process.php';

// GET TIMEABLE BY ID
if(isset($_GET['timetable_id'])){
    $t_id = $_GET['timetable_id'];

    $result = $db->query("SELECT * FROM lesson where t_id='$t_id'") or die($db->error);
    $lesson_response = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $lesson = array();
        $lesson["id"] = $row["id"];
        $lesson["l_name"] = $row["lesson_name"];
        $lesson["l_code"] = $row["code"];
        $lesson["dep"] = $row["department"];
        $lesson["course"] = $row["course"];
        $lesson["year"] = $row["year_of_study"];
        $lesson["semester"] = $row["semester"];
        $lesson["fragment"] = $row["fragment"];
        $lesson["lec"] = $row["lecturer"];
        $lesson["room"] = $row["room"];
        $lesson["from"] = $row["from_time"];
        $lesson["to"] = $row["to_time"];
        $lesson["t_id"]=$row["t_id"];
        // $lesson["color"] = $row["color"];

        // push single lesson into final response array
        array_push($lesson_response, $lesson);
    }

    echo json_encode($lesson_response);

}

// GET ALL TIMETABLES 

if(isset($_GET['timetable_all'])){
    $result = $db->query("SELECT * FROM timetables ORDER BY course") or die($db->error);
    $timetables_response = array();
    while ($row = $result->fetch_assoc()) {
        $timetables = array();
        $timetables['id']=$row['id'];
        $timetables['department'] = $row['department'];
        $timetables['course'] = $row['course'];
        $timetables['year'] = $row['year'];
        $timetables['semester'] = $row['semester'];

        // PUT TIMETABLE DETAILS INTO AN ARRAY
        array_push($timetables_response, $timetables);
    }

    echo json_encode($timetables_response);

}

// GET EXAM TIMETABLE BY ID
if(isset($_GET['exam_id'])){
    $t_id = $_GET['exam_id'];

    $result = $db->query("SELECT * FROM exam where t_id='$t_id'") or die($db->error);
    $exam_response = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $exams = array();
        $exams["id"] = $row["id"];
        $exams["e_name"] = $row["name"];
        $exams["e_code"] = $row["code"];
        $exams["dep"] = $row["department"];
        $exams["course"] = $row["course"];
        $exams["year"] = $row["year_of_study"];
        $exams["semester"] = $row["semester"];
        $exams["supervisor"] = $row["supervisor"];
        $exams["date"] = $row["exam_date"];
        $exams["room"] = $row["room"];
        $exams["from"] = $row["from_time"];
        $exams["to"] = $row["to_time"];
        $exams["t_id"] = $row["t_id"];
        // $lesson["color"] = $row["color"];

        // push single lesson into final response array
        array_push($exam_response, $exams);
    }

    echo json_encode($exam_response);

}

// VIEW TIMETABLE WITHOUT GETTING IT

if(isset($_GET['vtimetable_id']) && isset($_GET['day'])){
    $t_id = $_GET['vtimetable_id'];
    $day = $_GET['day'];

    $result = $db->query("SELECT * FROM lesson where t_id='$t_id' and fragment='$day'") or die($db->error);
    $lesson_response = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $lesson = array();
        $lesson["id"] = $row["id"];
        $lesson["l_name"] = $row["lesson_name"];
        $lesson["l_code"] = $row["code"];
        $lesson["dep"] = $row["department"];
        $lesson["course"] = $row["course"];
        $lesson["year"] = $row["year_of_study"];
        $lesson["semester"] = $row["semester"];
        $lesson["fragment"] = $row["fragment"];
        $lesson["lec"] = $row["lecturer"];
        $lesson["room"] = $row["room"];
        $lesson["from"] = $row["from_time"];
        $lesson["to"] = $row["to_time"];
        $lesson["t_id"] = $row["t_id"];
        // $lesson["color"] = $row["color"];

        // push single lesson into final response array
        array_push($lesson_response, $lesson);
    }

    echo json_encode($lesson_response);
}




?>
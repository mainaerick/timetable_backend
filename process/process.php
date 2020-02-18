<?php
include 'connect.php';
session_start();
$error_msg='';



$editdep_name='';

$editlessonname = '';
$editfragment = '';
$editlecturer = '';
$editroom = '';
$editfromtime = '';
$edittotime = '';
$editlessoncode = '';
$editlessoncourse = '';
$editlessonsemester = '';
$editlessonyear = '';

$update = false;

$editexamname = '';
$editexamdate = '';
$editexamcode = '';
$editexamcourse = '';
$editexamsemester = '';
$editexamroom = '';
$editexamsupervisor = '';
$editexamfromtime = '';
$edittotime = '';
$editexamyear = '';
$update = false;
$course_id = '';

$editcoursename = '';
$editcourseyears = '';
// click edit on exams

// if (isset($_GET['examedit'])) {
//     $update = true;
//     $id = $_GET['edit'];
//     $result = $db->query("select * from exam where id='$id'") or die(mysqli_errorno());
//     if (count($result) == 1) {

//         $row = $result->fetch_array();
//         $editexamname = $row['name'];
//         $editexamdate = $row['date'];
//         $editexamsupervisor = $row['supervisor'];
//         $editexamfromtime = $row['from'];
//         $editexamtotime = $row['to'];
//         $editexamcode = $row['code'];
//         $editexamcourse = $row['course'];
//         $editexamsemester = $row['semester'];
//         $editexamroom = $row['room'];
//     }
// }

// update row in exam

if (isset($_POST['update_exam'])) {
    $id = $_POST['exam_id'];
    $examname = $_POST['examname'];
    $examdate = $_POST['examdate'];
    $examsupervisor = $_POST['examsupervisor'];
    $examfromtime = date('H:i', strtotime($_POST['examfromtime']));
    $examtotime = date('H:i', strtotime($_POST['examtotime']));
    $examcode = $_POST['examcode'];
    $examcourse = $_POST['examcourse'];
    $examsemester = $_POST['examsemester'];
    $examroom = $_POST['examroom'];
    $examyear = $_POST['examyear'];
    $dept = $_SESSION['ldep'];

    // echo $examname;
    // echo "/";
    // echo $examdate;
    // echo "/";
    // echo $examsupervisor;
    // echo "/";
    // echo  $examfromtime;
    // echo "/";
    // echo $examtotime;
    // echo "/";
    // echo $examcode;
    // echo "/";
    // echo $examcourse;
    // echo "/";
    // echo  $examsemester;
    // echo "/";
    // echo $examroom;
    if (get_totime($examdate,$examtotime) <= get_fromtime($examdate,$examfromtime)){
        header("location: ../exams/exams.php?error");
    }


    else{
        //VALIDATE lecture
        $v_lec = $db->query("SELECT * FROM exam WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND date='$examdate' AND supervisor='$examsupervisor'");

        // VALIDATE room
        $v_room = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND date='$examdate' AND room='$examroom'");

        // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
        $v_time = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND date='$examdate' AND course='$examcourse' AND 
        year_of_study='$examyear' AND semester='examsemester' AND room='$room' AND lecturer='$lecturer'");

        $timedisplay = date('h:i A', strtotime($fromtime)) . " - " . date('h:i A', strtotime($totime));

        if ($v_time->num_rows) { // TIME IS OCCUPIED, NOTIFY THE USER 
            header("location: ../exams/exams.php?error_timeoccupied=$timedisplay");
        } elseif ($v_room->num_rows) { //ROOM IS OCCUPIED
            header("location: ../exams/exams.php?error_roomoccupied=$timedisplay");
        } elseif ($v_lec->num_rows) { // LECTURER NOT FREE
            header("location: ../exams/exams.php?error_lecoccupied=$timedisplay");
        } else {
            $db->query("update exam set name='$examname',
            code='$examcode',
            department='$dept',
            course='$examcourse',
            semester='$examsemester',
            supervisor='$examsupervisor',
            year_of_study='$examyear',
            date='$examdate',
            from_time='$examfromtime',
            to_time='$examtotime',
            room='$examroom'
            where id=$id;") or die($db->error);

            header("location: ../exams/exams.php?saved");

        }

        

    }


    
}

// display data to update in inputboxes

if (isset($_GET['editexam'])) {
    $update = true;
    $id = $_GET['editexam'];
    $_SESSION['exam_add_open'] = 'opened';
    $result = $db->query("select * from exam where id='$id'") or die(mysqli_errorno());
    if (count($result) == 1) {
        $row = $result->fetch_array();
        $editexamname = $row['name'];
        $editexamdate = $row['date'];
        $editexamsupervisor = $row['supervisor'];
        $editexamfromtime = date('h:i A', strtotime($row['from_time']));
        $editexamcode = $row['code'];
        $editexamcourse = $row['course'];
        $editexamsemester = $row['semester'];
        $editexamroom = $row['room'];
        $editexamtotime = date('h:i A', strtotime($row['to_time']));
        $editexamyear = $row['year_of_study'];
    }
}


// save exam
if (isset($_POST['save_exam'])) {
    // date('h:i A',strtotime());
    $id = $_POST['exam_id'];
    $examname = $_POST['examname'];
    $examdate = $_POST['examdate'];
    $examsupervisor = $_POST['examsupervisor'];
    $examfromtime = date('H:i', strtotime($_POST['examfromtime']));
    $examtotime = date('H:i', strtotime($_POST['examtotime']));
    $examcode = $_POST['examcode'];
    $examcourse = $_POST['examcourse'];
    $examsemester = $_POST['examsemester'];
    $examroom = $_POST['examroom'];
    $examyear = $_POST['examyear'];
    $dept = $_SESSION['ldep_name'];


    // $date1 = "12-02-2020 12:02 am";
//     $date1 = $examdate." ".$examfromtime;
// // $date2 = "12-02-2020 12:03 am";
//     $date2 = $examdate. " ".$examtotime;
//     $curtimestamp1 = strtotime($date1);
//     $curtimestamp2 = strtotime($date2);

    if (get_totime($examdate,$examtotime) <= get_fromtime($examdate,$examfromtime)){
        header("location: ../exams/exams.php?error");
    }


    else{
        // echo "$date1 is older than $date2";
        //VALIDATE lecture
        $v_lec = $db->query("SELECT * FROM exam WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND date='$examdate' AND supervisor='$examsupervisor'");

        // VALIDATE room
        $v_room = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND date='$examdate' AND room='$examroom'");

        // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
        $v_time = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND date='$examdate' AND course='$examcourse' AND 
        year_of_study='$examyear' AND semester='examsemester' AND room='$room' AND lecturer='$lecturer'");

        $timedisplay = date('h:i A', strtotime($fromtime)) . " - " . date('h:i A', strtotime($totime));

        if ($v_time->num_rows) { // TIME IS OCCUPIED, NOTIFY THE USER 
            header("location: ../exams/exams.php?error_timeoccupied=$timedisplay");
        } elseif ($v_room->num_rows) { //ROOM IS OCCUPIED
            header("location: ../exams/exams.php?error_roomoccupied=$timedisplay");
        } elseif ($v_lec->num_rows) { // LECTURER NOT FREE
            header("location: ../exams/exams.php?error_lecoccupied=$timedisplay");
        } else {
        $db->query("insert into exam values(null,'$examname',
        '$examcode',
        '$dept',
        '$examcourse',
        '$examyear',
        '$examsemester',
        '$examsupervisor',    
        '$examdate',
        '$examfromtime',
        '$examtotime',
        '$examroom');")
        or die(mysqli_error($db));
            header("location: ../exams/exams.php?saved");

    }


}
}

function validation($db){
    

}
function getTime ($ymd, $hi) {
    return strtotime($ymd." ".$hi);
}

function get_fromtime($date,$time){
    $date1 = $date." ".$time;
    // $date2 = "12-02-2020 12:03 am";
    return strtotime($date1);
}

function get_totime($date,$time){
    $date2 = $date. " ".$time;

    return strtotime($date2);
}
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}


if (isset($_GET['deleteexam'])) {
    $id = $_GET['deleteexam'];
    $db->query("Delete from exam where id= '$id'") or die($mysqli->error());
    header("location: ../exams/exams.php");
}

if (isset($_GET['edit'])) {
    $update = true;
    $id = $_GET['edit'];
    $_SESSION['lesson_add_open'] = "opened";

    $result = $db->query("select * from lesson where id='$id'") or die(mysqli_errorno());
    if ($result->num_rows == 1) {

        $row = $result->fetch_array();
        $editlessonname = $row['lesson_name'];
        $editfragment = $row['fragment'];
        $editlecturer = $row['lecturer'];
        $editroom = $row['room'];
        $editfromtime = date('h:i A', strtotime($row['from_time']));
        $edittotime = date('h:i A', strtotime($row['to_time']));
        $editlessoncode = $row['code'];
        $editlessoncourse = $row['course'];
        $editlessonsemester = $row['semester'];
        $editlessonyear = $row['year_of_study'];
        //     '$code',
        // '$dept',
        // '$course',
        // '$year',
        // '$semester',
        // '$fragment',
        // '$lecturer',
        // '$room',
        // '$fromtime',
        // '$totime',
        // '$color',
        // '$course_id
    }
}

// update lesson
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $lessonname = $_POST['lesson_name'];
    $fragment = $_POST['fragment'];
    $lecturer = $_POST['lecturer'];
    $room = $_POST['room'];
    $fromtime = date('H:i', strtotime($_POST['fromtime']));
    $totime = date('H:i', strtotime($_POST['totime']));
    $color = -1;
    $dept = $_SESSION['ldep_name'];
    $code = $_POST['lesson_code'];
    $course = $_POST['lcourse'];
    $semester = $_POST['lesson_semester'];
    $year = $_POST['lesson_year'];

    // $result = $db->query("select * from courses where course_name='$course'");
    // if (count($result) == 1) {

    //     $row = $result->fetch_array();

    //     $course_id = $row['id'];
    // }

    $default_date='12-02-2020';


    if (get_totime($default_date,$totime) <= get_fromtime($default_date,$fromtime)){ //validate times
        header("location: ../lesson/lesson.php?error");
    }

    else{

        //VALIDATE lecture
        $v_lec = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND lecturer='$lecturer'");

        // VALIDATE room
        $v_room = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND room='$room'");

        // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
        $v_time = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND course_id='$last_id' AND room='$room' AND lecturer='$lecturer'");

        $timedisplay = date('h:i A', strtotime($fromtime)) . " - " . date('h:i A', strtotime($totime));

        if ($v_time->num_rows) { // TIME IS OCCUPIED, NOTIFY THE USER 
            header("location: ../lesson/lesson.php?error_timeoccupied=$timedisplay");
        } elseif ($v_room->num_rows) { //ROOM IS OCCUPIED
            header("location: ../lesson/lesson.php?error_roomoccupied=$timedisplay");
        } elseif ($v_lec->num_rows) { // LECTURER NOT FREE
            header("location: ../lesson/lesson.php?error_lecoccupied=$timedisplay");
        } else {

            $t_result = $db->query("select * from timetables where 
        department='$dept' and 
        course='$course' and 
        year='$year' and 
        semester='$semester'");

            if ($t_result->num_rows) {

                $t_row = $t_result->fetch_array();

                $t_id = $t_row['id'];

                $db->query("update lesson set lesson_name='$lessonname',
            department='$dept',
            code='$code',
            course='$course',
            year_of_study='$year',
            semester='$semester',
            fragment='$fragment',
            lecturer='$lecturer',
            room='$room',
            from_time='$fromtime',
            to_time='$totime',
            color='$color'
            course_id=$t_id
             where id=$id;") or die($db->error);
            } else {
                $db->query("insert into timetables values(null,
            '$dept',
            '$course',
            '$year',
            '$semester'
            )") or die($db->error);

                $last_id_q = $db->query("select * from timetables ORDER BY id DESC LIMIT 1;");
                $row = $last_id_q->fetch_array();
                $last_id = $row['id'];

                $db->query("update lesson set lesson_name='$lessonname',
            department='$dept',
            code='$code',
            course='$course',
            year_of_study='$year',
            semester='$semester',
            fragment='$fragment',
            lecturer='$lecturer',
            room='$room',
            from_time='$fromtime',
            to_time='$totime',
            color='$color',
            course_id=$last_id 
            where id=$id;") or die($db->error);
            }

            header("location: ../lesson/lesson.php?saved");
        }
        

    }
    
}

// delete lesson

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $db->query("Delete from lesson where id= '$id'") or die($db->error());
    header("location: ../lesson/lesson.php");
}



// save lesson

if (isset($_POST['save_lesson'])) {

    $lessonname = $_POST['lesson_name'];
    $fragment = $_POST['fragment'];
    $lecturer = $_POST['lecturer'];
    $room = $_POST['room'];
    $fromtime = date('H:i', strtotime($_POST['fromtime']));
    $totime = date('H:i', strtotime($_POST['totime']));
    $dept = $_SESSION['ldep_name'];
    $code = $_POST['lesson_code'];
    $course = $_POST['lcourse'];
    $semester = $_POST['lesson_semester'];
    $year = $_POST['lesson_year'];
    $color = -1;



    $result = $db->query("select * from courses where course_name='$course'");
    if ($result->num_rows) {

        $row = $result->fetch_array();
        $course_id = $row['id'];
    }

   
    // $db->query("insert into lesson values(null,'$lessonname',
    // '$code',
    // '$dept',
    // '$course',
    // '$year',
    // '$semester',
    // '$fragment',
    // '$lecturer',
    // '$room',
    // '$fromtime',
    // '$totime',
    // '$color',
    // '$course_id');") or die($db->error);


    // gets one item timetable
    // 
    $t_result=$db->query("select * from timetables where 
    department='$dept' and 
    course='$course' and 
    year='$year' and 
    semester='$semester'") or die($db->error);

    $default_date='12-02-2020';


    if (get_totime($default_date,$totime) <= get_fromtime($default_date,$fromtime)){ //validate times
        header("location: ../lesson/lesson.php?error");
    }
    else{
        
     //TIMETABLE EXIST 
    if($t_result->num_rows){
        $row=$t_result->fetch_array();
        $t_id=$row['id'];
    

        //VALIDATE lecturer
        $v_lec=$db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND lecturer='$lecturer'") or die($db->error);

        // VALIDATE room
        $v_room=$db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND room='$room'") or die($db->error);
       
        // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
        $v_time=$db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND course_id='$t_id' AND room='$room' AND lecturer='$lecturer'") or die($db->error);

        $timedisplay = date('h:i A', strtotime($fromtime))." - ". date('h:i A', strtotime($totime));

        if($v_time->num_rows){ // TIME IS OCCUPIED, NOTIFY THE USER 
            header("location: ../lesson/lesson.php?error_timeoccupied=$timedisplay");

        }
        elseif($v_room->num_rows){ //ROOM IS OCCUPIED
            header("location: ../lesson/lesson.php?error_roomoccupied=$timedisplay");

        }
        elseif($v_lec->num_rows){ // LECTURER NOT FREE
            header("location: ../lesson/lesson.php?error_lecoccupied=$timedisplay");
        }
        
        else{ // TIME/LEC/ROOM NOT OCCUPIED INSERT INTO DATABASE
            $db->query("insert into lesson values(null,'$lessonname',
            '$code',
            '$dept',
            '$course',
            '$year',
            '$semester',
            '$fragment',
            '$lecturer',
            '$room',
            '$fromtime',
            '$totime',
            '$color',
            $t_id);") or die($db->error);
            header("location: ../lesson/lesson.php?saved");

        }


        
    }

    // TIMETABLE DOESN'T EXIST

    else
    {
        

        $db->query("insert into timetables values(null,
        '$dept',
        '$course',
        '$year',
        '$semester'
        )") or die($db->error);


        // GET LAST ID AFTER TIMETABLE EXIST


        $last_id_q=$db->query("select * from timetables ORDER BY id DESC LIMIT 1;");
        $row=$last_id_q->fetch_array();
        $last_id=$row['id'];

            //VALIDATE lecture
            $v_lec = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND lecturer='$lecturer'");

            // VALIDATE room
            $v_room = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND room='$room'");

            // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
            $v_time = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND course_id='$last_id' AND room='$room' AND lecturer='$lecturer'");

            $timedisplay = date('h:i A', strtotime($fromtime)) . " - " . date('h:i A', strtotime($totime));

            if ($v_time->num_rows) { // TIME IS OCCUPIED, NOTIFY THE USER 
                header("location: ../lesson/lesson.php?error_timeoccupied=$timedisplay");
            } elseif ($v_room->num_rows) { //ROOM IS OCCUPIED
                header("location: ../lesson/lesson.php?error_roomoccupied=$timedisplay");
            } elseif ($v_lec->num_rows) { // LECTURER NOT FREE
                header("location: ../lesson/lesson.php?error_lecoccupied=$timedisplay");
            } else {// insert
                
                $db->query("insert into lesson values(null,'$lessonname',
                                                            '$code',
                                                            '$dept',
                                                            '$course',
                                                            '$year',
                                                            '$semester',
                                                            '$fragment',
                                                            '$lecturer',
                                                            '$room',
                                                            '$fromtime',
                                                            '$totime',
                                                            '$color',
                                                        last_id);") or die($db->error);
                header("location: ../lesson/lesson.php?saved");
            }

       
    
    
    }
    
    }




    
}
// edit course
if (isset($_GET['edit_course'])) {
    $update = true;
    $id = $_GET['edit_course'];
    $_SESSION['course_add_open'] = "opened";
    $result = $db->query("select * from courses where id=$id") or die(mysqli_errorno());
    if ($result->num_rows == 1) {

        $row = $result->fetch_array();

        $editcoursename = $row['course_name'];
        $editcourseyears =$row['years_of_study'];
    }
}

// update course
if (isset($_POST['update_course'])) {
    $id = $_POST['course_id'];
    $coursename = $_POST['course_name'];
    $course_years= $_POST['course_years'];
    $dept = $_SESSION['ldep'];

    $result = $db->query("select * from courses where course_name='$coursename'");

    if ($result->num_rows) {

        $_SESSION['course_exist'] = "Course already exists";
        header("location: ../course/course.php");
    } else {
        $db->query("update courses set course_name='$coursename',years_of_study='$course_years' where id=$id;");
        $db->query("update lesson set course='$coursename' where course_id=$id"); //update lessons' course too
        unset($_SESSION['course_add_open']);
        header("location: ../course/course.php?updated");
    }
}

// delete course
if (isset($_GET['delete_course'])) {
    $id = $_GET['delete_course'];
    $get_coursename=$db->query("select * from courses where id=$id") or die($db->error); 
    if ($get_coursename->num_rows) {
        $row = $get_coursename->fetch_array();
        $db->query("delete from courses where id=$id")  or die($db->error);
        $name=$row['course_name'];
        $db->query("delete from lesson where course='$name'") or die($db->error);

    }

    // header("location: ../course/course.php?deleted");
}

// insert course
if (isset($_POST['save_course'])) {

    $coursename = $_POST['course_name'];
    $dept = $_SESSION['ldep_name'];
    $course_years= $_POST['course_years'];

    $result = $db->query("select * from courses where course_name='$coursename'");

    if ($result->num_rows) {

        $_SESSION['course_exist'] = "Course already exists";
        header("location: ../course/course.php");
    } else {
        $db->query("insert into courses values(null,
        '$coursename',
        '$dept','$course_years');") or die($db->error);

        header("location: ../course/course.php?saved");
    }
}

if (isset($_POST['save_dep'])) {

    $new_dep_name = $_POST['department_name'];

    $result = $db->query("select * from departments where name='$new_dep_name'");

    if ($result->num_rows) {

        $_SESSION['dep_exist'] = "Department already exists";
        header("location: ../department/department.php");
    } else {
        $db->query("insert into departments values(null,
        '$new_dep_name',
        ' ');") or die($db->error);

        header("location: ../department/department.php?saved");
    }
}
if (isset($_GET['edit_dep'])) {
    $update = true;
    $name = $_GET['edit_dep'];
    $_SESSION['dep_add_open'] = "opened";
    $result = $db->query("select * from department where name='$name'") or die($db->error);
    if ($result->num_rows == 1) {

        $row = $result->fetch_array();

        $editdep_name = $row['name'];
    }
}

if (isset($_POST['update_dep'])) {
    $old_dep_name = $_POST['dep_name'];
    $new_dep_name = $_POST['department_name'];

    $result = $db->query("select * from departments where name='$new_dep_name'");

    if ($result->num_rows) {

        $_SESSION['dep_exist'] = "Department already exists";
        header("location: ../course/course.php");
    } else {
        $db->query("update courses set department='$new_dep_name' where department=$old_dep_name;");
        $db->query("update lesson set department='$new_dep_name' where department=$old_dep_name");
        $db->query("update timetables set department='$new_dep_name' where department=$old_dep_name");         //upadate all tables with the same department
        $db->query("update exams set department='$new_dep_name' where department=$old_dep_name");
        $db->query("update users set department='$new_dep_name' where department=$old_dep_name");
        $db->query("update department set name='$new_dep_name' where name=$old_dep_name");
        unset($_SESSION['course_add_open']);
        header("location: ../department/department.php?updated");
    }
}

// selection of course an putting it in session
if (isset($_GET['select_course'])) {
    $_SESSION['lcourse'] = $_GET['select_course'];
    $page = $_SESSION['page'];

    header("location: $page");
}

// --end

// selection of year of study and putting it in session
if (isset($_GET['yearone'])) {
    $_SESSION['year'] = "Year 1";
    $page = $_GET['yearone'];
    $page = $_SESSION['page'];

    header("location: $page");
}
if (isset($_GET['yeartwo'])) {
    $_SESSION['year'] = "Year 2";
    $page = $_SESSION['page'];

    header("location: $page");
}

if (isset($_GET['yearthree'])) {
    $_SESSION['year'] = "Year 3";
    $page = $_SESSION['page'];

    header("location: $page");
}

if (isset($_GET['yearfour'])) {
    $_SESSION['year'] = "Year 4";
    $page = $_SESSION['page'];

    header("location: $page");
}

if (isset($_GET['yearfive'])) {
    $_SESSION['year'] = "Year 5";
    $page = $_SESSION['page'];

    header("location: $page");
}
if (isset($_GET['yearsix'])) {
    $_SESSION['year'] = "Year 6";
    $page = $_SESSION['page'];

    header("location: $page");
}

// --end

// selection of semester and putting it in session

if (isset($_GET['semone'])) {
    $_SESSION['semester'] = "Semester 1";
    $page = $_SESSION['page'];

    header("location: $page");
}
if (isset($_GET['semtwo'])) {
    $_SESSION['semester'] = "Semester 2";
    $page = $_SESSION['page'];

    header("location: $page");
}
// --end
if (isset($_GET['semthree'])) {
    $_SESSION['semester'] = "Semester 3";
    $page = $_SESSION['page'];

    header("location: $page");
}

// lesson add form is shown
if (isset($_GET['addlesson'])) {
    $_SESSION['lesson_add_open'] = "opened"; //ensure input stays shown
    $page = $_SESSION['page'];
    header("location: $page");
}
// lesson add form is hidden
if (isset($_GET['doneaddlesson'])) {
    unset($_SESSION['lesson_add_open']);
    $page = $_SESSION['page'];
    header("location: $page");
}
// exam add foen is shown
if (isset($_GET['addexam'])) {
    $_SESSION['exam_add_open'] = 'opened';
    $page = $_SESSION['page'];
    header("location: $page");
}
// exam add form is hidden
if (isset($_GET['hide_exam_add'])) {
    unset($_SESSION['exam_add_open']);
    $page = $_SESSION['page'];
    header("location: $page");
}


// course add form is shown
if (isset($_GET['addcourse'])) {
    $_SESSION['course_add_open'] = "opened";
    $page = $_SESSION['page'];
    header("location: $page");
}
if (isset($_GET['hidecourseadd'])) {
    unset($_SESSION['course_add_open']);
    $page = $_SESSION['page'];
    header("location: $page");
}



if (isset($_POST['login'])) {
    $name = $_POST['username'];
    $lpass = $_POST['password'];
    // $ldepartment = $_POST['ldepartment'];
    $result = $db->query("select * from users where username= '$name' and password='$lpass'");
    
    if ($result->num_rows) {

        if($name==="eric"){
            while ($row = $result->fetch_assoc()) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['succ'];
    
            }
            header("location: ../admin/admin.php");

        }
        else{
            while ($row = $result->fetch_assoc()) {
                if($row['status']==="not approved"){
                    $_SESSION['login_err'] = "User Not Approved Yet!";
                    header("location: ../index.php");
    
                }
                else if($row['status']==="approved"){
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['succ'];
                    $_SESSION['ldep_name']=$row['department'];
                    header("location: ../lesson/lesson.php");
                }
                // $_SESSION['ldep'] = $row['department'];
            }
        }
       
       
    } else {
        $_SESSION['login_err'] = "Invalid Username or Password";
        header("location: ../index.php");
    }
}

if (isset($_POST['signup'])){
    $u_name=$_POST['username'];
    $u_department=$_POST['department'];
    $u_email=$_POST['email'];
    $result = $db->query("select * from users where username= '$u_name' and department='$u_department'");
    if ($result->num_rows){
        $_SESSION['signup_err'] = "user already exist";
        header("location: ../signup/sinup.php");
    }
    else{
        $chk_dep=$db->query("select * from department where name='$u_department'");
        if ($chk_dep->num_rows) {
            # code...
            $db->query("insert into users values(null,'$u_name','1234','$u_department','not approved','$u_email')") or die($db->error);
        $_SESSION['signup_err'] = "User created successfully, an email will be sent after aprroval";
        header("location: ../signup/sinup.php");
        }
        else{
            $_SESSION['signup_err'] = "No department with that name";
        header("location: ../signup/sinup.php");
        }

        
    }

}

if (isset($_GET['approve'])){
    $user_id=$_GET['approve'];
    $db->query("update users set status='approved' where id=$user_id;") or die($db->error);
    header("location: ../users/users.php");


}

if (isset($_GET['dis_approve'])){
    $user_id=$_GET['dis_approve'];
    $db->query("update users set status='not approved' where id=$user_id;") or die($db->error);
    header("location: ../users/users.php");

}


if (isset($_POST['change_dept'])) {
    $new_name = $_POST['dept_new_name'];
    $result = $db->query("SELECT * FROM department WHERE name='$new_name'");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            unset($_SESSION['ldep']);
            $_SESSION['ldep'] = $row['id'];
            $_SESSION['ldep_name']=$row['name'];
            unset($_SESSION['no_dep']);
            unset($_SESSION['lcourse']);
        }
        $page = $_SESSION['page'];
        header("location: $page");
    } else {
        $_SESSION['no_dep']="Invalid Department Name";
        $page = $_SESSION['page'];
        header("location: $page");
    }
}

if (isset($_POST['dep_search'])) {
    $result = $db->query("SELECT * FROM department WHERE name LIKE '%{$_POST['dep_search']}%' LIMIT 2 ");
    $output = '';

    // $db->query("select * from department order by name asc");
    // $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_array($result)) {



            // $output .= '<ul class="list-group">
            //   <a href="../lesson/lesson.php"> <li class="list-group-item">' . $user['name'] . '</li></a>

            // </ul>';
            //     $output.='<select id="output" class="selectpicker with-ajax" data-live-search="true">
            //     <option value="'.$user['name'].'">'.$user['name'].'</option>
            // </select>';

            // echo "<p>" . $user['name'] . "</p>";
            
            echo '<a class="nav-link" href="#">' . $user['name'] . '</a><br>';
        
            // echo $user['name']."<br/>";
            // echo $output;
        }
    } else {
        echo "<p style='color:red'>Department not found...</p>";
    }
}

if(isset($_GET['view_timetable_lesson'])){
    $id=$_GET['view_timetable_lesson'];
    $result = $db->query("SELECT * FROM timetables WHERE id=$id");
    while ($row = mysqli_fetch_array($result)) {
        $dept_name=$row['department'];
        $ltablecourse=$row['course'];
        $lyear=$row['year'];
        $lsemester=$row['semester'];
    }
}
if(isset($_GET['view_timetable_exam'])){
    $id=$_GET['view_timetable_exam'];
    $result = $db->query("SELECT * FROM timetables WHERE id=$id");
    while ($row = mysqli_fetch_array($result)) {
        $dept=$row['department'];
        $ltablecourse=$row['course'];
        $lyear=$row['year'];
        $lsemester=$row['semester'];
}
}



if(isset($_GET['timeslots'])){
    $start_time = '07:00';  //start time as string
    $end_time = '19:00';  //end time as string
    $booked = array();
    $day= $_GET['timeslots'];
    $course_name=$_GET['course_name'];
    $yearselected = $_GET['selected_year'];;
    $semester_selected = $_GET['selected_semester'];
    // array('12:00-13:00', '14:00-15:00');    //booked slots as arrays
    // $dep_namefor_time = $_SESSION['ldep_name'];
    
    $course_namefortime = $_SESSION['lcourse'];
    if(empty($course_name) || empty($yearselected) || empty($semester_selected)){
        $out=array();
        $text="please select a course, year and semester to view free timeslots";
        array_push($out,$text);
        echo json_encode($out);
        
    }
    else{

        $result = $db->query("select * from lesson where fragment='$day' and
    course='$course_name' and
    year_of_study='$yearselected' and
    semester='$semester_selected'"); // GET TIME ALLOCTED IN THE DB
    if ($result->num_rows) {
            while ($row = $result->fetch_array()) {
                // print_r("Allocated time=>   ".$row['from_time']."-". $row['to_time']);
                $time_set = '12:00-14:00';
                // $row['from_time']."-". $row['to_time'];

                // PARTITION THE TIME IN TERMS OF ONE HOUR
                $start = DateTime::createFromFormat('H:i', $row['from_time']);  //create date time objects
                $end = DateTime::createFromFormat('H:i', $row['to_time']);  //create date time objects

                for ($i = $start; $i < $end;)  //for loop 
                {
                    $start_t = $i->format('H:i');   //take hour and minute
                    $i->modify("+60 minutes");      //add 20 minutes
                    $stop_t = $i->format('H:i');     //take hour and minute
                    $time_set = $start_t . "-" . $stop_t;
                    // print_r($time_set);
                    array_push($booked, $time_set);
                }
            }

        $start = DateTime::createFromFormat('H:i', $start_time);  //create date time objects
        $end = DateTime::createFromFormat('H:i', $end_time);  //create date time objects
        $count = 0;  //number of slots
        $out = array();   //array of slots 
        for ($i = $start; $i < $end;)  //for loop 
        {
            $avoid = false;   //booked slot?
            $time1 = $i->format('H:i');   //take hour and minute
            $i->modify("+60 minutes");      //add 60 minutes/1 HR
            $time2 = $i->format('H:i');     //take hour and minute
            $slot = $time1 . "-" . $time2;      //create a format 12:40-13:00 etc
            for ($k = 0; $k < sizeof($booked); $k++)  //if booked hour
            {
                if ($booked[$k] == $slot)  //check
                    $avoid = true;   //yes. booked

            }
            if (!$avoid && $i < $end)  //if not booked and less than end time
            {
                $count++;           //add count
                $slots = $time1 . "-" . $time2;
                echo "\n";         //add count
                array_push($out, $slots); //add slot to array
            }
        }
        echo json_encode($out);
        
    }
    else{
            $out = array();
            $text = "error communication with the server";
            array_push($out, $text);
            echo json_encode($out);
    }
        
    // print_r($out) ;

    // $m = 0;
    // while ($m < $count) {

    // // echo '<option>';
    // echo $out[$m];
    // // echo '</option>';

    // $m++;}
    
}
    
}

    
        








// if($result->num_rows){
    // $password=$row['password'];
// while($row=$result->fetch_assoc()){
        //     $name=$row['username'];
            
            // if($_POST['username']==$name && $_POST['password']==$password){
            //     header("location:../lesson/lesson.php");
            // }
            // else{
            //     $_SESSION['login_err']="Invalid Username or Password";
            //     header("location:../index.php");

            // }
            
        // }
        
    // }
    

// }
// else{
//     $db->error;
// }
//     if(isset($_POST['submit'])){
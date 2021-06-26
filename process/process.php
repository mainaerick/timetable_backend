<?php
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
session_start();
$error_msg = '';



$editdep_name = '';

$editlessonname = '';
$editfragment = '';
$editlecturer = '';
$editlec_reg = '';
$editroom = '';
$editfromtime = '';
$edittotime = '';
$editlessoncode = '';
$editlessoncourse = '';
$editlessonsemester = '';
$editlessonyear = '';
$edit_stdno = '';

$update = false;

$editexamname = '';
$editexamdate = '';
$editexamcode = '';
$editexamcourse = '';
$editexamsemester = '';
$editexamroom = '';
$editexamsupervisor = '';
$editexamfromtime = '';
$editexamtotime = '';
$editexamyear = '';
$update = false;
$course_id = '';
$editexamsupervisor_reg = '';
$exam_roomcapacity = '';
$exam_lecid = '';


$editcoursename = '';
$editcourseyears = '';


$editlec_reg_no = '';
$editlecname = '';
$editlecemail = '';


$editroomname = '';
$editroomcapacity = '';

$unit_name = '';
$unit_code = '';
$unit_capacity = '';

$editunitname = '';
$editunitcode = '';
$editunityear = '';
$editunitsemester = '';
$editunitnature = '';
$editregisteredno = '';
$courseunitid = '';

// $unitname = $_POST['unit_name'];
// $code = $_POST['unit_code'];
// $year = $_POST['unit_year'];
// $semester = $_POST['unit_semester'];
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

// update exam
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
    $dept = $_SESSION['ldep_name'];
    $editexamsupervisor_reg = $_POST['examsupervisor_reg'];
    $exam_lecid = $_SESSION['exam_lecid'];
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
    $t_id = "";

    $_SESSION['e_saved_data'] = array();

    array_push(
        $_SESSION['e_saved_data'],
        $examname,
        $examdate,
        $examsupervisor,
        date('h:i A', strtotime($examfromtime)),
        $examcode,
        $examcourse,
        $examsemester,
        $examroom,
        date('h:i A', strtotime($examtotime)),
        $examyear,

        getlec_regbyid($db, $exam_lecid),
        $exam_lecid
    );
    if (get_totime($examdate, $examtotime) <= get_fromtime($examdate, $examfromtime)) {
        header("location: ../exams/exams.php?error");
    } else {

        $t_result = $db->query("select * from timetables where 
        department='$dept' and 
        course='$examcourse' and 
        year='$examyear' and 
        semester='$examsemester'") or die($db->error);
        if ($t_result->num_rows) {
            $t_row = $t_result->fetch_array();

            $t_id = $t_row['id'];
        }

        $course_id;
        $result = $db->query("select * from courses where course_name='$examcourse'");

        if ($result->num_rows) {

            $row = $result->fetch_array();
            $course_id = $row['id'];
        }
        //VALIDATE lecture
        $v_lec = $db->query("SELECT * FROM exam WHERE TIME(from_time) BETWEEN '$examfromtime' AND '$examtotime' AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND exam_date='$examdate' AND supervisor='$exam_lecid'");

        // VALIDATE room
        $v_room = $db->query("SELECT * FROM exam WHERE TIME(from_time) BETWEEN '$examfromtime' AND '$examtotime' AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND exam_date='$examdate' AND room='$examroom'");

        // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
        $v_time = $db->query("SELECT * FROM exam WHERE TIME(from_time) BETWEEN '$examfromtime' AND '$examtotime' AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND exam_date='$examdate' AND course='$course_id' AND 
        year_of_study='$examyear' AND semester='examsemester' AND room='$examroom' AND supervisor='$exam_lecid'");

        $timedisplay = date('h:i A', strtotime($examfromtime)) . " - " . date('h:i A', strtotime($examtotime));

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
            supervisor='$exam_lecid',
            year_of_study='$examyear',
            exam_date='$examdate',
            from_time='$examfromtime',
            to_time='$examtotime',
            room='$examroom',
            t_id='$t_id',
            course_id='$course_id' 
            where id=$id;") or die($db->error);
            unset($_SESSION['e_saved_data']);

            notify_($db, "Exam TimeTable Updated", $examcode . "-" . $examname . " updated. Exam date: " . $examdate, $t_id);

            header("location: ../exams/exams.php?saved");
        }
    }
}

// display data to update in inputboxes

if (isset($_GET['editexam'])) {
    $update = true;
    $id = $_GET['editexam'];
    $_SESSION['exam_add_open'] = 'opened';
    $result = $db->query("select * from exam where id='$id'") or die($db->error);
    if ($result->num_rows == 1) {
        $row = $result->fetch_array();
        $editexamname = $row['name'];
        $editexamdate = $row['exam_date'];
        $editexamsupervisor = getlecbyid($db, $row['supervisor']);
        $editexamfromtime = date('h:i A', strtotime($row['from_time']));
        $editexamcode = $row['code'];
        $editexamcourse = $row['course'];
        $editexamsemester = $row['semester'];
        $editexamroom = $row['room'];
        $editexamtotime = date('h:i A', strtotime($row['to_time']));
        $editexamyear = $row['year_of_study'];
        $editexamsupervisor_reg = getlec_regbyid($db, $row['supervisor']);
        $exam_roomcapacity = getunitcapacitybycode($db, $row['code']);
        $_SESSION['exam_lecid'] = $row['supervisor'];
    }
}


// save exam
if (isset($_POST['save_exam'])) {
    // date('h:i A',strtotime());
    $id = $_POST['exam_id'];
    $examname = $_POST['examname'];
    $examdate = $_POST['examdate'];
    $examsupervisor = getlecidbyreg($db, $_POST['examsupervisor_reg']);
    $examfromtime = date('H:i', strtotime($_POST['examfromtime']));
    $examtotime = date('H:i', strtotime($_POST['examtotime']));
    $examcode = $_POST['examcode'];
    $examcourse = $_POST['examcourse'];
    $examsemester = $_POST['examsemester'];
    $examroom = $_POST['examroom'];
    $examyear = $_POST['examyear'];
    $dept = $_SESSION['ldep_name'];

    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];

    $_SESSION['exam_fromdate'] = $fromdate;
    $_SESSION['exam_todate'] = $todate;


    $_SESSION['e_saved_data'] = array();

    array_push(
        $_SESSION['e_saved_data'],
        $examname,
        $examdate,
        getlecbyid($db, $examsupervisor),
        date('h:i A', strtotime($examfromtime)),
        $examcode,
        $examcourse,
        $examsemester,
        $examroom,
        date('h:i A', strtotime($examtotime)),
        $examyear,
        getlec_regbyid($db, $examsupervisor)
    );


    // $date1 = "12-02-2020 12:02 am";
    //     $date1 = $examdate." ".$examfromtime;
    // // $date2 = "12-02-2020 12:03 am";
    //     $date2 = $examdate. " ".$examtotime;
    //     $curtimestamp1 = strtotime($date1);
    //     $curtimestamp2 = strtotime($date2);

    if (get_totime($examdate, $examtotime) <= get_fromtime($examdate, $examfromtime)) {
        header("location: ../exams/exams.php?error");
    } else {
        $t_result = $db->query("select * from timetables where 
        department='$dept' and 
        course='$examcourse' and 
        year='$examyear' and 
        semester='$examsemester'") or die($db->error);
        $t_id;
        if ($t_result->num_rows) {
            $t_row = $t_result->fetch_array();

            $t_id = $t_row['id'];
        }

        $course_id;
        $result = $db->query("select * from courses where course_name='$examcourse'");

        if ($result->num_rows) {

            $row = $result->fetch_array();
            $course_id = $row['id'];
        }
        // echo "$date1 is older than $date2";
        //VALIDATE lecture
        $v_lec = $db->query("SELECT * FROM exam WHERE TIME(from_time) BETWEEN '$examfromtime' AND '$examtotime' AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND exam_date='$examdate' AND supervisor='$examsupervisor'");
        // "SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$examfromtime' AND '$examtotime' AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime'";
        // VALIDATE room
        $v_room = $db->query("SELECT * FROM exam WHERE TIME(from_time) BETWEEN '$examfromtime' AND '$examtotime' AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND exam_date='$examdate' AND room='$examroom'");

        // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
        $v_time = $db->query("SELECT * FROM exam WHERE TIME(from_time) BETWEEN '$examfromtime' AND '$examtotime' AND TIME(to_time) BETWEEN '$examfromtime' AND '$examtotime' AND exam_date='$examdate' AND course='$examcourse' AND 
        year_of_study='$examyear' AND semester='examsemester' AND room='$room' AND lecturer='$lecturer'");

        $timedisplay = date('h:i A', strtotime($examfromtime)) . " - " . date('h:i A', strtotime($examtotime));

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
        '$examroom',
        '$t_id',
        '$course_id',
        'ongoing'
    
    );") or die(mysqli_error($db));
            unset($_SESSION['e_saved_data']);
            header("location: ../exams/exams.php?saved");
        }
    }
}
function getcoursebyid($db, $id)
{
    $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from courses where id=$int_id") or die($db->error);
    $row = $result->fetch_array();
    $name = $row['course_name'];
    return $name;
}

function getlecbyid($db, $id)
{
    $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from lecturer where id=$int_id") or die($db->error);
    $row = $result->fetch_array();
    $name = $row['name'];
    // $name = $int_id;

    return $name;
}
function timestamptostr($times)
{
    $start = DateTime::createFromFormat('U', $times);
    $start->setTimezone(new DateTimeZone('UTC'));

    return $start->format('Y-m-d H:i');
}
function getlessonamebyid($db, $id)
{
    $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from lesson where id=$int_id") or die($db->error);
    $row = $result->fetch_array();
    $l_name_code = $row['code'] . "-" . $row['lesson_name'] . " " . $row['fragment'];
    return $l_name_code;
}

function getlecemailbyid($db, $id)
{
    $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from lecturer where id=$int_id") or die($db->error);
    $row = $result->fetch_array();
    $email = $row['email'];
    return $email;
}
function getlec_regbyid($db, $id)
{
    $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from lecturer where id=$int_id") or die($db->error);
    $row = $result->fetch_array();
    $reg_no = $row['email'];
    return $reg_no;
}

function getlec_depbyid($db, $id)
{
    $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from lecturer where id=$int_id") or die($db->error);
    $row = $result->fetch_array();
    $deprt = $row['department'];
    return $deprt;
}
function getlecidbyreg($db, $reg_no)
{
    // $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from lecturer where email='$reg_no'") or die($db->error);
    $row = $result->fetch_array();
    $id = $row['id'];
    return $id;
}
function getdepbyid($db, $id)
{
    $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from department where id=$int_id") or die($db->error);
    $row = $result->fetch_array();
    $name = $row['name'];
    return $name;
}

function getroombyid($db, $id)
{
    $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from room where id=$int_id") or die($db->error);
    $row = $result->fetch_array();
    $name = $row['name'];
    return $name;
}
function getroomidbyname($db, $name)
{
    // $int_id = intval($id);
    // alert($int_id);
    $result = $db->query("select * from room where name='$name'") or die($db->error);
    $row = $result->fetch_array();
    $id = $row['id'];
    return $id;
}

function getunit_bycode($db, $code)
{
    $unit_result = $db->query("SELECT * FROM units WHERE code='$code'");
    $row = $unit_result->fetch_array();
    $std_no = $row['stud_no'];

    return $std_no;
}

function getunitcapacitybycode($db, $code)
{
    $capacity_result = $db->query("SELECT * FROM units WHERE code='$code'");
    $row = $capacity_result->fetch_array();
    $std_no = $row['stud_no'];

    return $std_no;
}
function getTime($ymd, $hi)
{
    return strtotime($ymd . " " . $hi);
}

function get_fromtime($date, $time)
{
    $date1 = $date . " " . $time;
    // $date2 = "12-02-2020 12:03 am";
    return strtotime($date1);
}

function get_totime($date, $time)
{
    $date2 = $date . " " . $time;

    return strtotime($date2);
}

function get_usernamebyid($db, $id)
{
    $capacity_result = $db->query("SELECT * FROM users WHERE id='$id'");
    $row = $capacity_result->fetch_array();
    $std_no = $row['username'];

    return $std_no;
}
function get_useremailbyid($db, $id)
{
    $capacity_result = $db->query("SELECT * FROM users WHERE id='$id'");
    $row = $capacity_result->fetch_array();
    $std_no = $row['email'];

    return $std_no;
}

function alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

if (isset($_POST['reset_pass'])) {
    $email = $_POST['email'];
    $new_pas = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_password'];
    $result = $db->query("select * from users where email='$email';") or die($db->error);
    if ($result->num_rows == 1) {
        $db->query("update users set password='$new_pas' where email='$email';") or die($db->error);
        send_mail_pass_reset($db, $email, "location: ../index.php", $new_pas);
    }

    // header("location: ../index.php");


}
if (isset($_POST['changeusername'])) {
    $id = $_SESSION['id'];
    $username = $_POST['changeusername'];
    $email = $_POST['changeemail'];
    $db->query("update users set username='$username',email='$email' where id=$id;") or die($db->error);
    header("location: ../lesson/lesson.php");
}
if (isset($_POST['changepass'])) {
    $id = $_SESSION['id'];
    $new_pas = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_password'];
    $db->query("update users set password='$new_pas' where id=$id;") or die($db->error);
    header("location: ../lesson/lesson.php");
}
if (isset($_GET['deleteexam'])) {
    $id = $_GET['deleteexam'];
    $db->query("Delete from exam where id= '$id'") or die($mysqli->error());
    header("location: ../exams/exams.php");
}

// edit lesson
if (isset($_GET['edit'])) {
    $update = true;
    $id = $_GET['edit'];
    $_SESSION['lesson_add_open'] = "opened";

    $result = $db->query("select * from lesson where id='$id'") or die(mysqli_error($db));
    if ($result->num_rows == 1) {

        $row = $result->fetch_array();
        $editlessonname = $row['lesson_name'];
        $editfragment = $row['fragment'];
        $editlecturer = getlecbyid($db, $row['lecturer']);
        $editroom = getroombyid($db, $row['room']);
        $editfromtime = date('h:i A', strtotime($row['from_time'])) or die("error");
        $edittotime = date('h:i A', strtotime($row['to_time'])) or die("error");
        $editlessoncode = $row['code'];
        $editlessoncourse = $row['course'];
        $editlessonsemester = $row['semester'];
        $editlessonyear = $row['year_of_study'];
        $editlec_reg = getlec_regbyid($db, $row['lecturer']);
        $edit_stdno = getunit_bycode($db, $row['code']);

        //  '$code',
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
    $lecturer = getlecidbyreg($db, $_POST['lec_reg']);
    $room = getroomidbyname($db, $_POST['room']);;
    $fromtime = date('H:i', strtotime($_POST['fromtime']));
    $totime = date('H:i', strtotime($_POST['totime']));
    $color = -1;
    $dept = $_SESSION['ldep_name'];
    $code = $_POST['lesson_code'];
    $course = $_POST['lcourse'];
    $semester = $_POST['lesson_semester'];
    $year = $_POST['lesson_year'];


    $_SESSION['lsaveddata'] = array();

    array_push(
        $_SESSION['lsaveddata'],
        $lessonname,
        $fragment,
        getlecbyid($db, $lecturer),
        getroombyid($db, $room),
        $_POST['fromtime'],
        $_POST['totime'],
        $code,
        $course,
        $semester,
        $year,
        getlec_regbyid(
            $db,
            $lecturer
        ),
        getunit_bycode($db, $code)
    );
    // $result = $db->query("select * from courses where course_name='$course'");
    // if (count($result) == 1) {

    //     $row = $result->fetch_array();

    //     $course_id = $row['id'];
    // }

    $default_date = '12-02-2020';
    $course_id;
    $t_id;
    $result = $db->query("select * from courses where course_name='$course'");
    if ($result->num_rows) {

        $row = $result->fetch_array();
        $course_id = $row['id'];
    }

    if (get_totime($default_date, $totime) <= get_fromtime($default_date, $fromtime)) { //validate times
        header("location: ../lesson/lesson.php?error");
    } else {

        $t_result = $db->query("select * from timetables where 
        department='$dept' and 
        course='$course' and 
        year='$year' and 
        semester='$semester'");

        if ($t_result->num_rows) {

            $t_row = $t_result->fetch_array();

            $t_id = $t_row['id'];
            //VALIDATE lecture
            $v_lec = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND lecturer='$lecturer' AND lesson_name!='$lessonname'");

            // VALIDATE room
            $v_room = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND room='$room' AND lesson_name!='$lessonname'");

            // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
            $v_time = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND t_id='$t_id' AND room='$room' AND lecturer='$lecturer' AND lesson_name!='$lessonname'");

            $timedisplay = date('h:i A', strtotime($fromtime)) . " - " . date('h:i A', strtotime($totime));

            if ($v_time->num_rows) { // TIME IS OCCUPIED, NOTIFY THE USER 
                header("location: ../lesson/lesson.php?error_timeoccupied=$timedisplay");
            } elseif ($v_room->num_rows) { //ROOM IS OCCUPIED
                header("location: ../lesson/lesson.php?error_roomoccupied=$timedisplay");
            } elseif ($v_lec->num_rows) { // LECTURER NOT FREE
                header("location: ../lesson/lesson.php?error_lecoccupied=$timedisplay");
            } else {
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
            t_id=$t_id,
            course_id=$course_id
            where id=$id;") or die($db->error);

                if (!empty($_SESSION['timechange'])) {
                    unset($_SESSION['timechange']);
                    $_SESSION['feedback_id'] = $id;
                    $email = $_SESSION['email'];
                    alert($email);

                    if (date('H:i', strtotime($_SESSION['flessonfrom'])) == $fromtime && date('H:i', strtotime($_SESSION['flessonto'])) == $totime) {
                        $resolvefeedback = $_SESSION['feedback_id'];
                        // header("location: ../process/process.php?mailfeedback");
                        $now = new DateTime();
                        $now->setTimezone(new DateTimeZone('Europe/London'));
                        $nowtm = $now->format('Y-m-d H:i');
                        alert($feedback_id);
                        $db->query("update feedback set reply_date='$nowtm' where id=$resolvefeedback;") or die($db->error);
                        unset($_SESSION['lsaveddata']);
                        send_mail_feedback($email);
                    }
                }
                header("location: ../lesson/lesson.php?saved");
            }
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
            $t_id = $last_id;
            //VALIDATE lecture
            $v_lec = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND lecturer='$lecturer' AND lesson_name!='$lessonname'");

            // VALIDATE room
            $v_room = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND room='$room' AND lesson_name!='$lessonname'");

            // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
            $v_time = $db->query("SELECT * FROM lesson WHERE TIME(from_time) AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND t_id='$last_id' AND room='$room' AND lecturer='$lecturer' AND lesson_name!='$lessonname'");

            $timedisplay = date('h:i A', strtotime($fromtime)) . " - " . date('h:i A', strtotime($totime));

            if ($v_time->num_rows) { // TIME IS OCCUPIED, NOTIFY THE USER 
                header("location: ../lesson/lesson.php?error_timeoccupied=$timedisplay");
            } elseif ($v_room->num_rows) { //ROOM IS OCCUPIED
                header("location: ../lesson/lesson.php?error_roomoccupied=$timedisplay");
            } elseif ($v_lec->num_rows) { // LECTURER NOT FREE
                header("location: ../lesson/lesson.php?error_lecoccupied=$timedisplay");
            } else {
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
            t_id=$last_id ,
            course_id=$course_id

            where id=$id;") or die($db->error);

                if (!empty($_SESSION['timechange'])) {
                    if (date('H:i', strtotime($_SESSION['flessonfrom'])) == $fromtime && date('H:i', strtotime($_SESSION['flessonto'])) == $totime) {
                        unset($_SESSION['timechange']);
                        $_SESSION['feedback_id'] = $id;
                        $email = $_SESSION['email'];

                        $resolvefeedback = $_SESSION['feedback_id'];
                        // header("location: ../process/process.php?mailfeedback");
                        $now = new DateTime();
                        $now->setTimezone(new DateTimeZone('Europe/London'));
                        $nowtm = $now->format('Y-m-d H:i');
                        alert($feedback_id);
                        $db->query("update feedback set reply_date='$nowtm' where id=$resolvefeedback;") or die($db->error);
                        unset($_SESSION['lsaveddata']);
                        send_mail_feedback($email);
                    }
                }
                header("location: ../lesson/lesson.php?saved");
            }
        }
    }
    notify_($db, "TimeTable Updated", $code . "-" . $lessonname . " updated. Day: " . $fragment . " Time: " . $fromtime . "-" . $totime, $t_id);
    // unset($_SESSION['email']);
    // unset($_SESSION['timechange']);
    // unset($_SESSION['flessonfrom']);
    // unset($_SESSION['flessonto']);
}
if (isset($GET['mailfeedback'])) {
    $email = $_SESSION['email'];
    $resolvefeedback = $_SESSION['feedback_id'];

    send_mail_feedback($email);
}

// delete lesson

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $db->query("Delete from lesson where id= '$id'") or die($db->error);
    header("location: ../lesson/lesson.php");
}


// calculate a lesson time per week


if (isset($_GET['calculate'])) {
    if (chklesson_hour($db, "sit 101")) {
        echo "true";
    } else {
        echo "false";
    }
}
function chklesson_hour($db, $code)
{
    $v_lec = $db->query("SELECT * FROM lesson where code='$code'");
    $default_date = '12-02-2020';
    $sum = 0;
    while ($row = $v_lec->fetch_assoc()) {
        $fromtime = $row['from_time'];
        $totime = $row['to_time'];
        // // echo diff(get_fromtime($default_date, $fromtime),get_totime($default_date,$totime));

        // date_default_timezone_set('America/New_York');

        $interval = new \DateInterval('PT1H');

        //DST starts Apr. 2nd 02:00 and moves to 03:00
        $start = new DateTime('2006/04/01 ' + $fromtime + ':00');
        $end = new DateTime('2006/04/02 ' + $totime + ':00');
        // date_diff(get_fromtime($default_date, $fromtime), get_totime($default_date, $totime));
        $periods = new DatePeriod($start, $interval, $end);
        $hours = iterator_count($periods);
        $sum += $hours;
        // $datetime1 = new DateTime('2009/10/11 '+ $fromtime);
        // $datetime2 = new DateTime('2009/10/13 '+ $totime);
        // $interval = $datetime1->diff($datetime2);
        // echo $interval->format('%R%h days');

    }

    if ($sum >= 3) {
        return true;
    } else {
        return false;
    }
}

// save school
if (isset($_POST['save_school'])) {
    $name = $_POST['schoolname'];
    $query = $db->query("SELECT * FROM school where name='$name'") or die($db->error);
    if ($query->num_rows) {
        $_SESSION['school_exist'] = "School exists";
    } else {
        $db->query("INSERT into school values(null,'$name')") or die($db->error);
    }
    header("location: ../school/school.php");
}
if (isset($_GET['adddeptoschool'])) {
    $id = $_GET['adddeptoschool'];
    $sch_id = $_GET['schoolid'];

    $db->query("update department set school=$sch_id where id=$id") or die($db->error);
}

// save lesson

if (isset($_POST['save_lesson'])) {

    $lessonname = $_POST['lesson_name'];
    $fragment = $_POST['fragment'];
    $lecturer = getlecidbyreg($db, $_POST['lec_reg']);
    $room = getroomidbyname($db, $_POST['room']);
    $fromtime = date('H:i', strtotime($_POST['fromtime']));
    $totime = date('H:i', strtotime($_POST['totime']));
    $dept = $_SESSION['ldep_name'];
    $code = $_POST['lesson_code'];
    $course = $_POST['lcourse'];
    $semester = $_POST['lesson_semester'];
    $year = $_POST['lesson_year'];
    $color = -1;
    $status = "ongoing";

    $_SESSION['lsaveddata'] = array();

    array_push(
        $_SESSION['lsaveddata'],
        $lessonname,
        $fragment,
        getlecbyid($db, $lecturer),
        getroombyid($db, $room),
        $_POST['fromtime'],
        $_POST['totime'],
        $code,
        $course,
        $semester,
        $year,
        getlec_regbyid(
            $db,
            $lecturer
        ),
        getunit_bycode($db, $code)
    );

    if (chklesson_hour($db, $code)) {
        die(header("location: ../lesson/lesson.php?hour_exceed"));
    }

    $course_id;
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
    $t_result = $db->query("select * from timetables where 
    department='$dept' and 
    course='$course' and 
    year='$year' and 
    semester='$semester'") or die($db->error);

    $default_date = '12-02-2020';
    $v_less = $db->query("SELECT * FROM units WHERE name='$lessonname' AND code='$code'") or die($db->error);


    if (get_totime($default_date, $totime) <= get_fromtime($default_date, $fromtime)) { //validate times
        header("location: ../lesson/lesson.php?error");
    } else {

        //TIMETABLE EXIST 
        if ($t_result->num_rows) {
            $row = $t_result->fetch_array();
            $t_id = $row['id'];

            // check availability of unit in db

            //VALIDATE lecturer
            $v_lec = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND lecturer='$lecturer'") or die($db->error);

            // VALIDATE room
            $v_room = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND room='$room'") or die($db->error);

            // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
            $v_time = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND t_id='$t_id' AND room='$room' AND lecturer='$lecturer'") or die($db->error);

            $timedisplay = date('h:i A', strtotime($fromtime)) . " - " . date('h:i A', strtotime($totime));

            if ($v_time->num_rows) { // TIME IS OCCUPIED, NOTIFY THE USER 
                header("location: ../lesson/lesson.php?error_timeoccupied=$timedisplay");
            } elseif ($v_room->num_rows) { //ROOM IS OCCUPIED
                $row = $v_room->fetch_array();

                $room_from = $row['from_time'];
                $room_to = $row['to_time'];
                $timedisplay_r = $room_from . " - " . $room_to;

                header("location: ../lesson/lesson.php?error_roomoccupied=$timedisplay_r");
            } elseif ($v_lec->num_rows) { // LECTURER NOT FREE
                header("location: ../lesson/lesson.php?error_lecoccupied=$timedisplay");
            } elseif (!$row = mysqli_fetch_array($v_less)) {
                header("location: ../lesson/lesson.php?lesson_exist_not");
            } else { // TIME/LEC/ROOM NOT OCCUPIED INSERT INTO DATABASE
                $editdep_name = '';
                $editlessonname = '';
                $editfragment = '';
                $editlecturer = '';
                $editlec_reg = '';
                $editroom = '';
                $editfromtime = '';
                $edittotime = '';
                $editlessoncode = '';
                $editlessoncourse = '';
                $editlessonsemester = '';
                $editlessonyear = '';
                $edit_stdno = '';

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
            $t_id,
            $course_id,
            '$status'
        );") or die($db->error);
                // echo $t_id;
                unset($_SESSION['lsaveddata']);
                header("location: ../lesson/lesson.php?saved");
            }
        }

        // TIMETABLE DOESN'T EXIST

        else {


            $db->query("insert into timetables values(null,
        '$dept',
        '$course',
        '$year',
        '$semester'
        )") or die($db->error);


            // GET LAST ID AFTER TIMETABLE EXIST


            $last_id_q = $db->query("select * from timetables ORDER BY id DESC LIMIT 1;");
            $row = $last_id_q->fetch_array();
            $last_id = $row['id'];

            //VALIDATE lecture
            $v_lec = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND lecturer='$lecturer'");
            // "SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' ";
            // VALIDATE room
            $v_room = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND room='$room'");

            // VALIDATE TIME OR CHECK IF TIME IS OCCUPIED 
            $v_time = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$fragment' AND t_id='$last_id' AND room='$room' AND lecturer='$lecturer'");

            $timedisplay = date('h:i A', strtotime($fromtime)) . " - " . date('h:i A', strtotime($totime));

            if ($v_time->num_rows) { // TIME IS OCCUPIED, NOTIFY THE USER 
                header("location: ../lesson/lesson.php?error_timeoccupied=$timedisplay");
            } elseif ($v_room->num_rows) { //ROOM IS OCCUPIED
                $row = $v_room->fetch_array();

                $room_from = $row['from_time'];
                $room_to = $row['to_time'];
                $timedisplay_r = $room_from . " - " . $room_to;

                header("location: ../lesson/lesson.php?error_roomoccupied=$timedisplay_r");
            } elseif ($v_lec->num_rows) { // LECTURER NOT FREE
                header("location: ../lesson/lesson.php?error_lecoccupied=$timedisplay");
            } elseif (!$row = mysqli_fetch_array($v_less)) {
                header("location: ../lesson/lesson.php?lesson_exist_not");
            } else { // insert
                $editdep_name = '';

                $editlessonname = '';
                $editfragment = '';
                $editlecturer = '';
                $editlec_reg = '';
                $editroom = '';
                $editfromtime = '';
                $edittotime = '';
                $editlessoncode = '';
                $editlessoncourse = '';
                $editlessonsemester = '';
                $editlessonyear = '';
                $edit_stdno = '';
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
                                                            $last_id,
                                                            $course_id,
                                                            '$status');") or die($db->error);
                unset($_SESSION['lsaveddata']);

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
        $editcourseyears = $row['years_of_study'];
    }
}

// update course
if (isset($_POST['update_course'])) {
    $id = $_POST['course_id'];
    $coursename = $_POST['course_name'];
    $course_years = $_POST['course_years'];
    $dept = $_SESSION['ldep'];

    $result = $db->query("select * from courses where course_name=''");

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
    $db->query("delete from courses where id=$id")  or die($db->error);
    $db->query("delete from lesson where course_id='$id'") or die($db->error);


    // header("location: ../course/course.php?deleted");
}

// save course
if (isset($_POST['save_course'])) {

    $coursename = $_POST['course_name'];
    $dept = $_SESSION['ldep_name'];
    $course_years = $_POST['course_years'];

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


// edit unit
if (isset($_GET['edit_unit'])) {
    $update = true;
    $id = $_GET['edit_unit'];
    $_SESSION['unit_add_open'] = "opened";
    $result = $db->query("select * from units where id=$id") or die($db->error);
    if ($result->num_rows == 1) {

        $row = $result->fetch_array();

        $editunitname = $row['name'];
        $editunitcode = $row['code'];
        $editunityear = $row['year'];
        $editunitsemester = $row['semester'];
        $editunitnature = $row['nature'];
        $editregisteredno = $row['stud_no'];
    }
}

// update unit
if (isset($_POST['update_unit'])) {
    $id = $_POST['unit_id'];
    $unitname = $_POST['unit_name'];
    $code = $_POST['unit_code'];
    $year = $_POST['unit_year'];
    $semester = $_POST['unit_semester'];
    $nature = $_POST['unit_nature'];
    $studno = $_POST['unitregno'];



    $result = $db->query("select * from units where course='$course' and code='$code' and year='$year' and semester='$semester' and nature='$nature'");

    if ($result->num_rows) {

        $_SESSION['unit_exist'] = "Unit already exists";
        header("location: ../course/course.php");
    } else {
        $db->query("update units set name='$unitname',code='$code',year='$year',semester='$semester',nature='$nature',stud_no='$studno' where id=$id;") or die($db->error);
        // $db->query("update lesson set course='$coursename' where course_id=$id"); //update lessons' course too
        unset($_SESSION['unit_add_open']);
        header("location: ../course/course.php?updated");
    }
}
// delete unit
if (isset($_GET['delete_unit'])) {
    $id = $_GET['delete_unit'];
    $db->query("delete from units where id=$id")  or die($db->error);
    $db->query("delete from lesson where unit_id='$id'") or die($db->error);

    // header("location: ../course/course.php?deleted");
}

// save unit
if (isset($_POST['save_unit'])) {

    $course = $_POST['course_id'];
    $unitname = $_POST['unit_name'];
    $code = $_POST['unit_code'];
    $year = $_POST['unit_year'];
    $semester = $_POST['unit_semester'];
    $nature = $_POST['unit_nature'];
    $studno = $_POST['unitregno'];
    $min = 20;
    $max = 1000;
    // $studno = rand($min, $max);

    $result = $db->query("select * from units where course='$course' and code='$code' and year='$year' and semester='$semester' and nature='$nature'");

    if ($result->num_rows) {

        $_SESSION['unit_exist'] = "Unit already exists";
        header("location: ../course/course.php");
    } else {
        $db->query("insert into units values(null,
        '$unitname',
        '$code','$course','$semester','$year',$studno,'$nature');") or die($db->error);

        header("location: ../course/course.php?saved");
    }
}

// // delete lecturer
// if (isset($_GET['delete_lec'])) {
//     $id = $_GET['delete_lec'];
//     $db->query("delete from  where id=$id")  or die($db->error);
//     $db->query("delete from lesson where unit_id='$id'") or die($db->error);

//     // header("location: ../course/course.php?deleted");
// }
// edit lecturer
if (isset($_GET['edit_lecturer'])) {
    $update = true;
    $id = $_GET['edit_lecturer'];
    $_SESSION['lecturer_add_open'] = "opened";
    $result = $db->query("select * from lecturer where id=$id") or die($db->error);
    if ($result->num_rows == 1) {

        $row = $result->fetch_array();
        $editlecname = $row['name'];
        $editlecemail = $row['email'];
    }
}

// update lecturer
if (isset($_POST['update_lecturer'])) {
    $id = $_POST['lecturer_id'];
    $lec_name = $_POST['lec_name'];
    $lec_email = $_POST['lec_email'];
    $department = $_SESSION['ldep_name'];

    $result = $db->query("select * from lecturer where email='$lec_email' and id != $id");

    if ($result->num_rows) {

        $_SESSION['lecturer_exist'] = "Lecurer email already exist already exists";
        header("location: ../lecturers/lecturer.php");
    } else {
        $db->query("update lecturer set name='$lec_name',email='$lec_email' where id=$id;");
        // $db->query("update lesson set lecturer='$id' where lecturer='$id';");
        unset($_SESSION['lecturer_add_open']);
        header("location: ../lecturers/lecturer.php?updated");
    }
}


// save lecturer
if (isset($_POST['save_lecturer'])) {

    $lec_name = $_POST['lec_name'];
    $lec_email = $_POST['lec_email'];
    $department = $_SESSION['ldep_name'];

    $result = $db->query("SELECT * from lecturer where email='$lec_email' AND department='$department'");

    if ($result->num_rows) {

        $_SESSION['lecturer_exist'] = "Lecurer with that email exist already exists";
        header("location: ../lecturers/lecturer.php");
    } else {
        send_mail_lecpass($db, $lec_email, $lec_name, $department);
    }
}


// edit room
if (isset($_GET['edit_room'])) {
    $update = true;
    $id = $_GET['edit_room'];
    $_SESSION['room_add_open'] = "opened";
    $result = $db->query("select * from room where id=$id") or die(mysqli_errorno());
    if ($result->num_rows == 1) {

        $row = $result->fetch_array();

        $editroomname = $row['name'];
        $editroomcapacity = $row['capacity'];
    }
}
// update room
if (isset($_POST['update_room'])) {
    $id = $_POST['room_id'];
    $room_name = $_POST['room_name'];
    $room_capacity = $_POST['room_capacity'];
    $result = $db->query("select * from room where name=''");
    if ($result->num_rows) {

        $_SESSION['room_exist'] = "Room already exists";
        header("location: ../room/room.php");
    } else {
        $db->query("update room set name='$room_name',capacity='$room_capacity' where id=$id;");
        unset($_SESSION['room_add_open']);
        header("location: ../room/room.php?updated");
    }
}
// save room
if (isset($_POST['save_room'])) {

    $room_name = $_POST['room_name'];
    $room_capacity = $_POST['room_capacity'];

    $result = $db->query("select * from room where name='$room_name'");

    if ($result->num_rows) {

        $_SESSION['room_exist'] = "Room already exists";
        header("location: ../room/room.php");
    } else {
        $db->query("insert into room values(null,
        '$room_name',
        '$room_capacity');") or die($db->error);

        header("location: ../room/room.php?saved");
    }
}

// save department
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
    $_SESSION['course_id'] = $_GET['course_id'];
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
    // 
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
if (isset($_GET['adddep'])) {
    $_SESSION['dep_add_open'] = "opened";
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
    unset($_SESSION['e_saved_data']);

    unset($_SESSION['exam_add_open']);
    $page = $_SESSION['page'];
    header("location: $page");
}
if (isset($_GET['hide_dep_add'])) {
    unset($_SESSION['dep_add_open']);
    $page = $_SESSION['page'];
    header("location: $page");
}

// lecturer add form is hidden
if (isset($_GET['hidelectureradd'])) {
    unset($_SESSION['lecturer_add_open']);
    $page = $_SESSION['page'];
    header("location: $page");
}

// lecturer add form is shown
if (isset($_GET['addlecturer'])) {
    $_SESSION['lecturer_add_open'] = "opened"; //ensure input stays shown
    $page = $_SESSION['page'];
    header("location: $page");
}

// room add form is hidden
if (isset($_GET['hideroomadd'])) {
    unset($_SESSION['room_add_open']);
    $page = $_SESSION['page'];
    header("location: $page");
}
// unit add form is hidden
if (isset($_GET['hideunitadd'])) {
    unset($_SESSION['unit_add_open']);
    $page = $_SESSION['page'];
    header("location: $page");
}

// room add form is shown
if (isset($_GET['addroom'])) {
    $_SESSION['room_add_open'] = "opened"; //ensure input stays shown
    $page = $_SESSION['page'];
    header("location: $page");
}

// course add form is shown
if (isset($_GET['addcourse'])) {
    $_SESSION['course_add_open'] = "opened";
    $page = $_SESSION['page'];
    header("location: $page");
}
// unit add form is shown
if (isset($_GET['addunit'])) {
    // $courseunitid=$_GET['addunit'];
    $_SESSION['courseidunit'] = $_GET['addunit'];
    $_SESSION['unit_add_open'] = "opened";
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

        if ($name === "eric") {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['succ'];
            }
            header("location: ../admin/admin.php");
        } else {
            while ($row = $result->fetch_assoc()) {
                if ($row['status'] === "not approved") {
                    $_SESSION['login_err'] = "User Not Approved Yet!";
                    header("location: ../index.php");
                } else if ($row['status'] === "approved") {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['succ'];
                    $_SESSION['ldep_name'] = $row['department'];
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

if (isset($_POST['signup'])) {
    $u_name = $_POST['username'];
    $u_department = $_POST['department'];
    $u_email = $_POST['email'];
    $result = $db->query("select * from users where username= '$u_name' and department='$u_department'");
    if ($result->num_rows) {
        $_SESSION['signup_err'] = "user already exist";
        header("location: ../signup/sinup.php");
    } else {
        $chk_dep = $db->query("select * from department where name='$u_department'");
        if ($chk_dep->num_rows) {
            # code...
            $row = $chk_dep->fetch_assoc();
            $dep_id = $row["id"];
            $db->query("insert into users values(null,'$u_name','1234','$dep_id','not approved','$u_email')") or die($db->error);
            $_SESSION['signup_err'] = "User created successfully, an email will be sent after aprroval";
            header("location: ../signup/sinup.php");
        } else {
            $_SESSION['signup_err'] = "No department with that name";
            header("location: ../signup/sinup.php");
        }
    }
}

// confirm user
if (isset($_GET['approve'])) {
    $user_id = $_GET['approve'];
    $user_email = $_GET['user_email'];

    $result = $db->query("select * from users where id=$user_id") or die("approve" . $db->error);
    $row = $result->fetch_assoc();
    if ($row['password'] === "1234") {
        send_mail($db, $user_email, $user_id);
    } else {
        $db->query("update users set status='approved' where id=$user_id;") or die($db->error);
    }
    header("location: ../users/users.php");
}

if (isset($_GET['dis_approve'])) {
    $user_id = $_GET['dis_approve'];
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
            $_SESSION['ldep_name'] = $row['name'];
            unset($_SESSION['no_dep']);
            unset($_SESSION['lcourse']);
        }
        $page = $_SESSION['page'];
        header("location: $page");
    } else {
        $_SESSION['no_dep'] = "Invalid Department Name";
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

if (isset($_GET['view_timetable_lesson'])) {
    $id = $_GET['view_timetable_lesson'];
    $result = $db->query("SELECT * FROM timetables WHERE id=$id");
    while ($row = mysqli_fetch_array($result)) {
        $dept_name = $row['department'];
        $ltablecourse = $row['course'];
        $lyear = $row['year'];
        $lsemester = $row['semester'];
    }
}
if (isset($_GET['view_timetable_exam'])) {
    $id = $_GET['view_timetable_exam'];
    $result = $db->query("SELECT * FROM timetables WHERE id=$id");
    while ($row = mysqli_fetch_array($result)) {
        $dept = $row['department'];
        $ltablecourse = $row['course'];
        $lyear = $row['year'];
        $lsemester = $row['semester'];
    }
}

if (isset($_GET['resolvetimechange'])) {
    $id = $_GET['resolvetimechange'];
    $result = $db->query("SELECT * from feedback where id=$id") or die($db->error);
    $lesson_id;
    $content;
    $fromtime;
    $totime;
    $sender_id;
    $sender_email;

    while ($row = $result->fetch_assoc()) {
        $lesson_id = $row['lesson_id'];
        $content = $row['content'];
        $fromtime = $row['fromtime'];
        $totime = $row['totime'];
        $sender_id = $row['sender_id'];
    }
    $_SESSION['timechange'] = $content;
    $_SESSION['feedback_id'] = $id;
    $_SESSION['flessonfrom'] = $fromtime;
    $_SESSION['flessonto'] = $totime;
    $email_get = $db->query("SELECT * from lecturer where id=$sender_id") or die($db->error);
    while ($emailrow = $email_get->fetch_assoc()) {
        $sender_email = $emailrow['email'];
    }
    // alert($sender_email);
    $_SESSION['email'] = $sender_email;
    header("location: ../lesson/lesson.php?edit=$lesson_id");
}

if (isset($_GET['resolvefeedback'])) {
    $resolvefeedback = $_GET['resolvefeedback'];
    $type = $_GET['type'];
    $senderid = $_GET['senderid'];
    $lesson_id = $_GET['lesson_id']; //this is to assigned to buddy
    $buddy_id = $_GET['buddy_id'];
    $buddylesson = $_GET['buddylesson']; //this is to be assigned to lec

    // update lesson

    // select lesson to validate buddy if will be free
    $table_lessonswapper = $db->query("SELECT * FROM lesson WHERE id=$lesson_id") or die($db->query);



    $fromtime;
    $totime;
    $strtime;
    $fragmentday;
    while ($row = $table_lessonswapper->fetch_assoc()) {
        $fromtime = date('H:i', strtotime($row['from_time']));

        $totime = date('H:i', strtotime($row['to_time']));
        $fragmentday = $row['fragment'];
    }

    // validate buddy
    $v_lec_buddy = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$swapper_day' AND lecturer='$buddy_id'");

    if ($v_lec_buddy->num_rows) { //buddy cannot be allocated because of busiment
        // alert("sorry ". getlecbyid($db, $buddy_id)." will not be available at the swapped time");
        $db->query("update feedback set reply_date='conflicted' where id=$resolvefeedback;") or die($db->error); //put sender in the buddy's slot
        $row = $v_lec_buddy->fetch_assoc();
        echo "buddy occupies" . $row['id'];
        // header("location: ../feedback/feedback.php?occupied=$buddy_id");

    } else {
        // select lesson to validate the swapper
        $table_lesson_buddy = $db->query("SELECT * FROM lesson WHERE id=$buddylesson") or die($db->query); //get time allocated to buddy and validate the one come at that place
        while ($row = $table_lessonswapper->fetch_assoc()) {
            $fromtime = date('H:i', strtotime($row['from_time']));

            $totime = date('H:i', strtotime($row['to_time']));
            $fragmentday = $row['fragment'];
        }
        // validate swapper
        $v_lecss = $db->query("SELECT * FROM lesson WHERE TIME(from_time) BETWEEN '$fromtime' AND '$totime' AND TIME(to_time) BETWEEN '$fromtime' AND '$totime' AND fragment='$swapper_day' AND lecturer='$senderid'");
        if ($v_lecs->num_rows) { //buddy cannot be allocated because of busiment

            $db->query("update feedback set reply_date='conflicted' where id=$resolvefeedback;") or die($db->error); //put sender in the buddy's slot
            $row = $v_lecs->fetch_assoc();
            // echo "swapper occupies".$row['id'];
            header("location: ../feedback/feedback.php?occupied=$senderid");
        } else {
            $db->query("update lesson set lecturer='$buddy_id' where id=$lesson_id;") or die($db->error); //put buddy in the sender's slot
            $db->query("update lesson set lecturer='$senderid' where id=$buddylesson;") or die($db->error); //put sender in the buddy's slot

            $now = new DateTime();
            $now->setTimezone(new DateTimeZone('Europe/London'));

            // echo $now->format('Y-m-d H:i:s');    // MySQL datetime format
            // echo $now->getTimestamp(); 
            $nowtm = $now->format('Y-m-d H:i');
            $db->query("update feedback set reply_date='$nowtm' where id=$resolvefeedback;") or die($db->error); //put sender in the buddy's slot

            header("location: ../feedback/feedback.php");
        }
    }


    // header("location: ../feedback/feedback.php");


}
if (isset($_GET['denyresolution'])) {
    alert("Todo send email to the sender of the feedback");
}
// test timeslots

if (isset($_GET['timeslots'])) {
    // details for test
    // $start_time = '07:00';  //start time as string
    // $end_time = '19:00';  //end time as string
    // $booked = array();
    // $day = 'monday'; //day selected
    // $course_name = 'BACHELOR OF INFORMATION TECHNOLOGY'; //course selected
    // $yearselected = 'Year 1'; //year selected
    // $semester_selected = 'Semester 1'; //semester selected
    // // $radio_value = $_GET['radio_value_text'];
    // $modify_time = '+180 minutes';
    // // if ($radio_value === 'single') {
    // //     $modify_time = '+60 minutes';
    // // } else if ($radio_value === 'double') {
    // //     $modify_time = '+120 minutes';
    // // } else if ($radio_value === 'tripple') {
    // //     $modify_time = '+180 minutes';
    // // } else {
    // //     $modify_time = '+60 minutes';
    // // }

    // // array('12:00-13:00', '14:00-15:00');    //booked slots as arrays
    // // $dep_namefor_time = $_SESSION['ldep_name'];

    // // $course_namefortime = $_SESSION['lcourse'];


    // if (empty($course_name) || empty($yearselected) || empty($semester_selected)) {
    //     $out = array();
    //     $text = "please select a course, year and semester to view free timeslots";
    //     array_push($out, $text);
    //     echo json_encode($out);
    // } else {

    if (empty($_SESSION['lcourse']) || empty($_SESSION['year']) || empty($_SESSION['semester'])) {
        $out = array();
        $text = "please select a course, year and semester then select day to view free timeslots";
        // alert($text);
        array_push($out, $text);
        echo json_encode($out);
    } else {
        $start_time = '07:00';  //start time as string
        $end_time = '19:00';  //end time as string
        $booked = array();
        $day = $_GET['timeslots']; //day selected
        $course_name = $_GET['course_name']; //course selected
        $yearselected = $_GET['selected_year']; //year selected
        $semester_selected = $_GET['selected_semester']; //semester selected
        $radio_value = $_GET['radio_value_text'];
        $modify_time;
        if ($radio_value === 'single') {
            $modify_time = '+60 minutes';
        } else if ($radio_value === 'double') {
            $modify_time = '+120 minutes';
        } else if ($radio_value === 'tripple') {
            $modify_time = '+180 minutes';
        } else {
            $modify_time = '+60 minutes';
        }
        $result = $db->query("select * from lesson where fragment='$day' and
    course='$course_name' and
    year_of_study='$yearselected' and
    semester='$semester_selected'") or die($db->error);
        // GET TIME ALLOCTED IN THE DB AND ADD THEM TO ARRAY BOOKED
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
                    $i->modify('+60 minutes');      //add 20 minutes
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
            $from_out = array();
            $to_out = array();
            $result_time1;
            $result_time2;
            $array_fromtime_result = array();
            $array_totime_result = array();
            for ($i = $start; $i < $end;)  //for loop TO GET THE TIME BETWEEN START TIME AND END TIME ADDING 1HOUR INTERVAL
            {
                $avoid = false;   //booked slot?
                $time1 = $i->format('H:i');   //take hour and minute
                $i->modify('+60 minutes');      //add 60 minutes/1 HR
                $time2 = $i->format('H:i');     //take hour and minute
                $slot = $time1 . "-" . $time2;      //create a format 12:40-13:00 etc

                // LOOP THROUGH BOOKED TIME AND REMOVE IT FROM FREE SLOTS
                // IF THEY MATH OVERALL TIME ARRAY IE 08:00(FROMDB)=08:00(FROMTIME ARRAY)
                for ($k = 0; $k < sizeof($booked); $k++)  //if booked hour
                {
                    if ($booked[$k] == $slot)  //check
                    {
                        $avoid = true;   //yes. booked

                    }
                }


                if (!$avoid && $i < $end)  //if not booked and less than end time
                {
                    $count++;           //add count

                    $slots = $time1 . "-" . $time2;
                    $from_slot = $time1;
                    $to_slot = $time2;

                    echo "\n";         //ADD A LINE

                    // FREE TIME SLOTS FROMTIME AND TOTIME SEPARATED
                    array_push($from_out, $from_slot); //ADD FROM TIME TO ARRAY FROM_SLOT
                    array_push($to_out, $to_slot); //ADD TO TIME TO ARRAY TO_SLOT
                }
            }


            // LOOP THROU FROM_TIME ADDing THE MODIFIED MINUTES EG 08:00 +60 MINUTES TO GET 09:00
            for ($m = 0; $m < sizeof($from_out); $m++) {
                $dfrom = DateTime::createFromFormat('H:i', $from_out[$m]);
                $dfrom->modify($modify_time);
                $mtime2 = $dfrom->format('H:i');
                for ($n = 0; $n < sizeof($to_out); $n++) {
                    if ($mtime2 == $to_out[$n]) {
                        $dateresultfrom = DateTime::createFromFormat('H:i', $from_out[$m]); //convert from time to date
                        $dateresultto = DateTime::createFromFormat('H:i', $to_out[$n]); //CONVERT TO TIME TO DATE
                        $result_time = $dateresultfrom->format('h:i A') . "-" . $dateresultto->format('h:i A'); //ASSIGN THE RESULT TO A STRING IE 09:00 AM- 10:00 AM
                        array_push($array_fromtime_result, $result_time); //ADD THE RESULT TO AN ARRAY
                    }
                }
            }
            echo json_encode($array_fromtime_result); //OUTPUT THE RESULT
        } else {
            $out = array();
            $start_time = '07:00';  //start time as string
            $end_time = '19:00';
            $start = DateTime::createFromFormat('H:i', $start_time);  //create date time objects
            $end = DateTime::createFromFormat('H:i', $end_time);
            for ($i = $start; $i < $end;)  //for loop 
            {
                $avoid = false;   //booked slot?
                $time1 = $i->format('h:i A');   //take hour and minute
                $i->modify($modify_time);      //add 60 minutes/1 HR
                $time2 = $i->format('h:i A');     //take hour and minute
                $slot = $time1 . "-" . $time2;
                // print_r($time_set);
                array_push($out, $slot);
            }
            // $text = "Empty time set from the database!";
            // array_push($out, $text);
            echo json_encode($out);
        }
    }
}

// get free timeslots
// old version 
if (isset($_GET['test_timeslots'])) {
    if (empty($_SESSION['lcourse']) || empty($_SESSION['year']) || empty($_SESSION['semester'])) {
        $out = array();
        $text = "please select a course, year and semester then select day to view free timeslots";
        // alert($text);
        array_push($out, $text);
        echo json_encode($out);
    } else {
        $start_time = '07:00';  //start time as string
        $end_time = '19:00';  //end time as string
        $booked = array();
        $day = $_GET['timeslots']; //day selected
        $course_name = $_GET['course_name']; //course selected
        $yearselected = $_GET['selected_year']; //year selected
        $semester_selected = $_GET['selected_semester']; //semester selected
        $radio_value = $_GET['radio_value_text'];
        $modify_time;
        if ($radio_value === 'single') {
            $modify_time = '+60 minutes';
        } else if ($radio_value === 'double') {
            $modify_time = '+120 minutes';
        } else if ($radio_value === 'tripple') {
            $modify_time = '+180 minutes';
        } else {
            $modify_time = '+60 minutes';
        }

        // array('12:00-13:00', '14:00-15:00');    //booked slots as arrays
        // $dep_namefor_time = $_SESSION['ldep_name'];

        $course_namefortime = $_SESSION['lcourse'];
        if (empty($course_name) || empty($yearselected) || empty($semester_selected)) {
            $out = array();
            $text = "please select a course, year and semester to view free timeslots";
            array_push($out, $text);
            echo json_encode($out);
        } else {

            $result = $db->query("select * from lesson where fragment='$day' and
    course='$course_name' and
    year_of_study='$yearselected' and
    semester='$semester_selected'") or die($db->error);
            // GET TIME ALLOCTED IN THE DB
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
                        $i->modify($modify_time);      //add 20 minutes
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
                    $time1 = $i->format('h:i A');   //take hour and minute
                    $i->modify($modify_time);      //add 60 minutes/1 HR
                    $time2 = $i->format('h:i A');     //take hour and minute
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
            } else {
                $out = array();
                $text = "Empty time set from the database!";
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
}


// get units
if (isset($_GET['units'])) {

    if (empty($_SESSION['semester']) || empty($_SESSION['lcourse']) || empty($_SESSION['year'])) {
    } else {
        $dept = $_SESSION['ldep_name'];
        $ltablecourse = $_SESSION['lcourse'];
        $lyear = $_SESSION['year'];
        $lsemester = $_SESSION['semester'];
        $course_id = $_SESSION['course_id'];
        // echo $lsemester."";
        $datalist_lesson = $db->query("select * from units where  course='$course_id' and year='$lyear' and semester='$lsemester';") or die($db->error);
        if (!empty($datalist_lesson)) {


            $row = mysqli_fetch_all($datalist_lesson, MYSQLI_ASSOC);

            // $row = $datalist_lesson->fetch_assoc();
            // $unit_name=$row['name'];
            // $unit_code=$row['code'];
            // $unit_capacity=$row=['capacity'];
            // $data   =   mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode($row);
        }
    }
}
// get rooms
if (isset($_GET['rooms'])) {
    $stud_no = $_GET['stud_no'];
    if (empty($_SESSION['semester']) || empty($_SESSION['lcourse']) || empty($_SESSION['year'])) {
    } else {
        $dept = $_SESSION['ldep_name'];
        $ltablecourse = $_SESSION['lcourse'];
        $lyear = $_SESSION['year'];
        $lsemester = $_SESSION['semester'];
        $course_id = $_SESSION['course_id'];
        $datalist_lesson = $db->query("SELECT * from room where capacity>=$stud_no and capacity<=$stud_no+50;") or die($db->error);
        if (!empty($datalist_lesson)) {


            $row = mysqli_fetch_all($datalist_lesson, MYSQLI_ASSOC);

            // $row = $datalist_lesson->fetch_assoc();
            // $unit_name=$row['name'];
            // $unit_code=$row['code'];
            // $unit_capacity=$row=['capacity'];
            // $data   =   mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode($row);
        }
    }
}
// get lecturers
if (isset($_GET['lecturer'])) {

    if (empty($_SESSION['semester']) || empty($_SESSION['lcourse']) || empty($_SESSION['year'])) {
    } else {
        $dept = $_SESSION['ldep_name'];
        $ltablecourse = $_SESSION['lcourse'];
        $lyear = $_SESSION['year'];
        $lsemester = $_SESSION['semester'];
        $course_id = $_SESSION['course_id'];
        $datalist_lesson = $db->query("select * from lecturer where department='$dept';") or die($db->error);
        if (!empty($datalist_lesson)) {
            $row = mysqli_fetch_all($datalist_lesson, MYSQLI_ASSOC);

            // $row = $datalist_lesson->fetch_assoc();
            // $unit_name=$row['name'];
            // $unit_code=$row['code'];
            // $unit_capacity=$row=['capacity'];
            // $data   =   mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode($row);
        }
    }
}
function isThisDayAWeekend($date)
{

    $timestamp = strtotime($date);

    $weekday = date("l", $timestamp);

    if ($weekday == "Saturday" or $weekday == "Sunday") {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET['autoexams_timeslots'])) {

    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    $ltablecourse = $_GET['examcourse'];
    $lyear = $_GET['examyear'];
    $lsemester = $_GET['examsemester'];
    $out = array();
    $booked = array();

    $starting_date = DateTime::createFromFormat('Y-m-d', $fromdate);  //create date time objects
    $end_end = DateTime::createFromFormat('Y-m-d', $todate);  //create date time objects

    $dates = array();
    // $tempsatrtdate = $start_date->format('Y-m-d');   //take hour and minute
    $starting_date->modify("-1 day");      //reverse one day
    $newstartdatestring = $starting_date->format('Y-m-d');
    $newstartdate = DateTime::createFromFormat('Y-m-d', $newstartdatestring);  //create date time objects

    for ($i = $newstartdate; $i < $end_end;)  //for loop 
    {
        $date1 = $i->format('Y-m-d');   //take hour and minute
        $i->modify("+1 day");      //add 20 minutes
        $date2 = $i->format('Y-m-d');     //take hour and minute
        $slot_date = $date2;
        // SKIP IF DAY IS WEEKEND
        if (!isThisDayAWeekend($date2)) {
            array_push($dates, $slot_date);
            $examquery = $db->query("select * from exam where exam_date='$slot_date' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';") or die($db->error);
            while ($row = $examquery->fetch_array()) {
                // $fromtime = $row['from_time'];
                // $totime = $row['to_time'];
                // $e_time=$fromtime."-".$totime;
                // array_push($booked,$e_time);


                $start_db = DateTime::createFromFormat('H:i', $row['from_time']);  //create date time objects
                $end_db = DateTime::createFromFormat('H:i', $row['to_time']);  //create date time objects
                //booked slots as arrays

                for ($i = $start_db; $i < $end_db;)  //for loop 
                {
                    $start_t = $i->format('H:i');   //take hour and minute
                    $i->modify("+120 minutes");      //add 20 minutes
                    $stop_t = $i->format('H:i');     //take hour and minute
                    $time_set = $start_t . "-" . $stop_t;
                    // print_r($time_set);
                    array_push($booked, $time_set);
                }
            }


            $start_time = $slot_date . ' 07:00:00';  //start time as string
            $end_time = $slot_date . ' 20:00:00';  //end time as string

            $start = DateTime::createFromFormat('Y-m-d H:i:s', $start_time);  //create date time objects
            $end = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);  //create date time objects
            $count = 0;  //number of slots

            for ($i = $start; $i < $end;)  //for loop 
            {
                $avoid = false;   //booked slot?
                $time1 = $i->format('H:i');   //take hour and minute
                $i->modify("+120 minutes");      //add 20 minutes
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
                    // $slots = ['start' => $time1, 'stop' => $time2];         //add count
                    $slots = $time1 . "-" . $time2 . ";" . $slot_date;
                    array_push($out, $slots); //add slot to array
                }
            }
        }
    }
    echo json_encode($out);

    // echo json_encode($dates);

}

if (isset($_GET['exams_timeslots'])) {
    // GET DATA
    $date = $_GET['exams_timeslots'];
    $ltablecourse = $_GET['examcourse'];
    $lyear = $_GET['examyear'];
    $lsemester = $_GET['examsemester'];

    $start_time = $date . ' 07:00:00';  //start time as string
    $end_time = $date . ' 20:00:00';  //end time as string
    $booked = array();    //booked slots as arrays
    $start = DateTime::createFromFormat('Y-m-d H:i:s', $start_time);  //create date time objects
    $end = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);  //create date time objects
    $count = 0;  //number of slots
    $out = array();   //array of slots 


    $examquery = $db->query("select * from exam where exam_date='$date' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';") or die($db->error);
    while ($row = $examquery->fetch_array()) {
        // $fromtime = $row['from_time'];
        // $totime = $row['to_time'];
        // $e_time=$fromtime."-".$totime;
        // array_push($booked,$e_time);


        $start_db = DateTime::createFromFormat('H:i', $row['from_time']);  //create date time objects
        $end_db = DateTime::createFromFormat('H:i', $row['to_time']);  //create date time objects

        for ($i = $start_db; $i < $end_db;)  //for loop 
        {
            $start_t = $i->format('H:i');   //take hour and minute
            $i->modify("+120 minutes");      //add 20 minutes
            $stop_t = $i->format('H:i');     //take hour and minute
            $time_set = $start_t . "-" . $stop_t;
            // print_r($time_set);
            array_push($booked, $time_set);
        }
    }


    for ($i = $start; $i < $end;)  //for loop 
    {
        $avoid = false;   //booked slot?
        $time1 = $i->format('H:i');   //take hour and minute
        $i->modify("+120 minutes");      //add 20 minutes
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
            // $slots = ['start' => $time1, 'stop' => $time2];         //add count
            $slots = $time1 . "-" . $time2;
            array_push($out, $slots); //add slot to array
        }
    }
    echo json_encode($out);



    // var_dump($out);   //array out
    // echo $count . " of slots available";

    //     $start_time = '2015-10-21 09:00:00';  //start time as string
    //     $end_time = '2015-10-21 19:45:00';  //end time as string
    //     $booked = ['2015-10-21 12:20:00', '2015-10-21 12:40:00', '2015-10-21 13:00:00', '2015-10-21 13:20:00'];
    //     //booked slots as arrays
    //     $start = DateTime::createFromFormat('Y-m-d H:i:s', $start_time);  //create date time objects
    //     $end = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);  //create date time objects
    //     $time1 = $start;
    //     $count = 0;  //number of slots
    //     $out = array();   //array of slots 
    //     for ($i = $start; $i < $end;)  //for loop 
    //     {
    //         $avoid = false;
    //         $t1 = date_timestamp_get($i);
    //         $t2 = $t1 + (20 * 60);

    //         for ($k = 0; $k < sizeof($booked); $k += 2)  //if booked hour
    //         {
    //             $st = DateTime::createFromFormat('Y-m-d H:i:s', $booked[$k]);
    //             $en = DateTime::createFromFormat('Y-m-d H:i:s', $booked[$k + 1]);

    //             if ($t1 >= date_timestamp_get($st) && $t2 <= date_timestamp_get($en))
    //                 $avoid = true;   //yes. booked
    //         }
    //         $slots = [$i->format('H:i'), $i->modify("+20 minutes")->format('H:i')];
    //         if (!$avoid && $i < $end)  //if not booked and less than end time
    //         {
    //             $count++;
    //             array_push($out, $slots);  //add slot to array
    //         }
    //     }
    //     var_dump($out);   //array out
    //     echo $count . " of slots available";
}


// if (isset($_GET['exams_timeslots'])) {
//     // GET DATA
//     $date = $_GET['exams_timeslots'];
//     $ltablecourse = $_GET['examcourse'];
//     $lyear = $_GET['examyear'];
//     $lsemester = $_GET['examsemester'];



//     $start_time = $date . ' 07:00:00';  //start time as string
//     $end_time = $date . ' 20:00:00';  //end time as string
//     $booked = array();    //booked slots as arrays
//     $start = DateTime::createFromFormat('Y-m-d H:i:s', $start_time);  //create date time objects
//     $end = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);  //create date time objects
//     $count = 0;  //number of slots
//     $out = array();   //array of slots 





//     $examquery = $db->query("select * from exam where exam_date='$date' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';") or die($db->error);
//     while ($row = $examquery->fetch_array()) {
//         // $fromtime = $row['from_time'];
//         // $totime = $row['to_time'];
//         // $e_time=$fromtime."-".$totime;
//         // array_push($booked,$e_time);


//         $start_db = DateTime::createFromFormat('H:i', $row['from_time']);  //create date time objects
//         $end_db = DateTime::createFromFormat('H:i', $row['to_time']);  //create date time objects

//         for ($i = $start_db; $i < $end_db;)  //for loop 
//         {
//             $start_t = $i->format('H:i');   //take hour and minute
//             $i->modify("+60 minutes");      //add 20 minutes
//             $stop_t = $i->format('H:i');     //take hour and minute
//             $time_set = $start_t . "-" . $stop_t;
//             // print_r($time_set);
//             array_push($booked, $time_set);
//         }
//     }


//     for ($i = $start; $i < $end;)  //for loop 
//     {
//         $avoid = false;   //booked slot?
//         $time1 = $i->format('H:i');   //take hour and minute
//         $i->modify("+60 minutes");      //add 20 minutes
//         $time2 = $i->format('H:i');     //take hour and minute
//         $slot = $time1 . "-" . $time2;      //create a format 12:40-13:00 etc

//         for ($k = 0; $k < sizeof($booked); $k++)  //if booked hour
//         {
//             if ($booked[$k] == $slot)  //check
//                 $avoid = true;   //yes. booked
//         }
//         if (!$avoid && $i < $end)  //if not booked and less than end time
//         {
//             $count++;           //add count
//             // $slots = ['start' => $time1, 'stop' => $time2];         //add count
//             $slots = $time1 . "-" . $time2;
//             array_push($out, $slots); //add slot to array
//         }
//     }
//     echo json_encode($out);
//     // var_dump($out);   //array out
//     // echo $count . " of slots available";

//     //     $start_time = '2015-10-21 09:00:00';  //start time as string
//     //     $end_time = '2015-10-21 19:45:00';  //end time as string
//     //     $booked = ['2015-10-21 12:20:00', '2015-10-21 12:40:00', '2015-10-21 13:00:00', '2015-10-21 13:20:00'];
//     //     //booked slots as arrays
//     //     $start = DateTime::createFromFormat('Y-m-d H:i:s', $start_time);  //create date time objects
//     //     $end = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);  //create date time objects
//     //     $time1 = $start;
//     //     $count = 0;  //number of slots
//     //     $out = array();   //array of slots 
//     //     for ($i = $start; $i < $end;)  //for loop 
//     //     {
//     //         $avoid = false;
//     //         $t1 = date_timestamp_get($i);
//     //         $t2 = $t1 + (20 * 60);

//     //         for ($k = 0; $k < sizeof($booked); $k += 2)  //if booked hour
//     //         {
//     //             $st = DateTime::createFromFormat('Y-m-d H:i:s', $booked[$k]);
//     //             $en = DateTime::createFromFormat('Y-m-d H:i:s', $booked[$k + 1]);

//     //             if ($t1 >= date_timestamp_get($st) && $t2 <= date_timestamp_get($en))
//     //                 $avoid = true;   //yes. booked
//     //         }
//     //         $slots = [$i->format('H:i'), $i->modify("+20 minutes")->format('H:i')];
//     //         if (!$avoid && $i < $end)  //if not booked and less than end time
//     //         {
//     //             $count++;
//     //             array_push($out, $slots);  //add slot to array
//     //         }
//     //     }
//     //     var_dump($out);   //array out
//     //     echo $count . " of slots available";
// }




// require_once "vendor/autoload.php";

if (isset($_GET['send_mail'])) {

    // $email_add= $_GET['send_mail'];
    send_mail($db, 'niteric@gmail.com', 1);
}

//MySQL server and database
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'Timetable';
$tables = '*';

//Call the core function
if (isset($_GET['backupdb'])) {
    backup_tables($dbhost, $dbuser, $dbpass, $dbname, $tables);
}


function send_mail_pass_reset($db, $email, $header, $pass)
{
    // $activation = md5(uniqid(rand(), true));
    $key = hash("joaat", uniqid(mt_rand(), true));
    $message = '<html><body>';
    $message .= '<h1 style="color:#f40;">Hi !</h1>';
    $message .= '<p style="color:#080;font-size:18px;">Dear Sir/Madam, Your account password was reset. New Password <h3>' . $pass . '</h3></p>';
    $message .= '</body></html>';

    //PHPMailer Object
    $mail = new PHPMailer;

    $mail->IsSMTP(); // enable SMTP
    // $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->isHTML();
    // optional
    // used only when SMTP requires authentication  
    $mail->SMTPAuth = true;
    $mail->Username = 'timetableku@gmail.com';
    $mail->Password = 'Dantolee!?__';

    //From email address and name
    $mail->From = "timetableku@gmail.com";
    $mail->FromName = "Kenyatta University Timetable";

    //To address and name
    $mail->addAddress($email); //Recipient name is optional

    //Address to which recipient will reply
    // $mail->addReplyTo("reply@yourdomain.com", "Reply");

    //CC and BCC
    // $mail->addCC("cc@example.com");
    // $mail->addBCC("bcc@example.com");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = "Account Password Reset";
    $mail->Body = "<i>$message</i>";
    $mail->AltBody = "You are receiving this email from Timetable admin. if it was not You please ingore this message. Thank You.";

    if (!$mail->send()) {
        alert("Email could not be sent");
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        // echo "Message has been sent successfully";
        header($header);
    }
}

// send mail for user confirm
function send_mail($db, $email, $user_id)
{
    // $activation = md5(uniqid(rand(), true));
    $key = hash("joaat", uniqid(mt_rand(), true));
    // $msg="Your Password is  ".$key;
    $message = '<html><body>';
    $message .= '<h1 style="color:#f40;">Hi !</h1>';
    $message .= '<p style="color:#080;font-size:18px;">Dear Sir/Madam, Your account password is <strong>' . $key . '.</strong> after approval </h3></p>';
    $message .= '</body></html>';
    //PHPMailer Object
    $mail = new PHPMailer;

    $mail->IsSMTP(); // enable SMTP
    // $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    // optional
    // used only when SMTP requires authentication  
    $mail->SMTPAuth = true;
    $mail->Username = 'erickmaina29@students.ku.ac.ke';
    $mail->Password = 'q.sill..';

    //From email address and name
    $mail->From = "erickmaina29@students.ku.ac.ke";
    $mail->FromName = "Kenyatta University Timetable";

    //To address and name
    $mail->addAddress($email); //Recipient name is optional

    //Address to which recipient will reply
    // $mail->addReplyTo("reply@yourdomain.com", "Reply");

    //CC and BCC
    // $mail->addCC("cc@example.com");
    // $mail->addBCC("bcc@example.com");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = "Timetable user approved";
    $mail->Body = "<i>$message</i>";
    $mail->AltBody = "You are receiving this email from Timetable admin. if it was not You please ingore this message. Thank You.";
    if (!$mail->send()) {

        alert("Email could not be sent");
        // echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        // echo "Message has been sent successfully";

        $db->query("update users set status='approved', password='$key' where id=$user_id;") or die($db->error);

        header("location: ../users/users.php");
    }
}


// send mail for lecturer password
function send_mail_lecpass($db, $lec_email, $lec_name, $department)
{
    // $activation = md5(uniqid(rand(), true));

    $key = hash("joaat", uniqid(mt_rand(), true));
    $msg = "Your Name and Password for login is  " . $key;

    //PHPMailer Object
    $mail = new PHPMailer;

    $mail->IsSMTP(); // enable SMTP
    // $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    // optional
    // used only when SMTP requires authentication  
    $mail->SMTPAuth = true;
    $mail->Username = 'erickmaina29@students.ku.ac.ke';
    $mail->Password = 'q.sill..';

    //From email address and name
    $mail->From = "erickmaina29@students.ku.ac.ke";
    $mail->FromName = "Kenyatta University Timetable";

    //To address and name
    $mail->addAddress($lec_email); //Recipient name is optional

    //Address to which recipient will reply
    // $mail->addReplyTo("reply@yourdomain.com", "Reply");

    //CC and BCC
    // $mail->addCC("cc@example.com");
    // $mail->addBCC("bcc@example.com");

    //Send HTML or Plain Text email
    $mail->isHTML(true);
    $mail->Subject = "Timetable password";
    $mail->Body = "<h2>$msg</h2>";
    $mail->AltBody = " Dear Sir/Madam, Please use the code above as your password to your account.
    You are receiving this email for Account Creation. if it was not You please ingore this message. Thank You.";


    if (!$mail->send()) {
        alert("Email could not be sent lecturer not added");
        // echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        // echo "Message has been sent successfully";

        $db->query("insert into lecturer values(null,
        '$lec_name',
        '$key','$lec_email','$department');") or die($db->error);

        header("location: ../lecturers/lecturer.php?saved");
    }
}


// send mail no notify feedback resolution
function send_mail_feedback($email)
{
    // $activation = md5(uniqid(rand(), true));
    // $key = hash("joaat", uniqid(mt_rand(), true));
    $msg = "Your timetable issue has being resolved";

    //PHPMailer Object
    $mail = new PHPMailer;

    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    // optional
    // used only when SMTP requires authentication  
    $mail->SMTPAuth = true;
    $mail->Username = 'erickmaina29@students.ku.ac.ke';
    $mail->Password = 'q.sill..';

    //From email address and name
    $mail->From = "erickmaina29@students.ku.ac.ke";
    $mail->FromName = "Kenyatta University Timetable";

    //To address and name
    $mail->addAddress($email); //Recipient name is optional

    //Address to which recipient will reply
    // $mail->addReplyTo("reply@yourdomain.com", "Reply");

    //CC and BCC
    // $mail->addCC("cc@example.com");
    // $mail->addBCC("bcc@example.com");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = "Timetable password";
    $mail->Body = "<i>$msg</i>";
    $mail->AltBody = "This is the plain text version of the email content";

    if (!$mail->send()) {
        alert("Email could not be sent");
        // echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        // echo "Message has been sent successfully";

        // header("location: ../feedback/feedback.php");
    }
}

//Core function
function backup_tables($host, $user, $pass, $dbname, $tables = '*')
{
    $link = mysqli_connect($host, $user, $pass, $dbname);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    mysqli_query($link, "SET NAMES 'utf8'");

    //get all of the tables
    if ($tables == '*') {
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    $return = '';
    //cycle through
    foreach ($tables as $table) {
        $result = mysqli_query($link, 'SELECT * FROM ' . $table);
        $num_fields = mysqli_num_fields($result);
        $num_rows = mysqli_num_rows($result);

        $return .= 'DROP TABLE IF EXISTS ' . $table . ';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE ' . $table));
        $return .= "\n\n" . $row2[1] . ";\n\n";
        $counter = 1;

        //Over tables
        for ($i = 0; $i < $num_fields; $i++) {   //Over rows
            while ($row = mysqli_fetch_row($result)) {
                if ($counter == 1) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                } else {
                    $return .= '(';
                }

                //Over fields
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }

                if ($num_rows == $counter) {
                    $return .= ");\n";
                } else {
                    $return .= "),\n";
                }
                ++$counter;
            }
        }
        $return .= "\n\n\n";
    }

    //save file
    $fileName = 'db-backup-' . time() . '-' . (md5(implode(',', $tables))) . '.sql';
    $handle = fopen($fileName, 'w+');
    fwrite($handle, $return);
    if (fclose($handle)) {
        echo "Done, the file name is: " . $fileName;
        exit;
    }
}

function filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $fromtime,  $totime, $day)
{
    // $lessons_result;
    if (isset($_GET['filter_value'])) {
        $filtervalue = $_GET['filter_value'];
        $which_col = $_GET['col_value'];
        // alert($filtervalue);
        $lessons_result = $db->query("SELECT * from lesson where fragment='$day' AND department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester' and $which_col='$filtervalue' AND
         (TIME(from_time)='$fromtime' OR TIME(to_time)='$totime' or
          '$fromtime' BETWEEN TIME(from_time) AND TIME(to_time) and '$totime' BETWEEN TIME(from_time) AND TIME(to_time)) 
                        ;") or die($db->error);
    } else {
        $lessons_result = $db->query("SELECT * from lesson where fragment='$day' AND department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester' and 
        (TIME(from_time)='$fromtime' OR TIME(to_time)='$totime' or
          '$fromtime' BETWEEN TIME(from_time) AND TIME(to_time) and '$totime' BETWEEN TIME(from_time) AND TIME(to_time))
        
                        ;") or die($db->error);
    }
    $table_data = '';
    if (!empty($lessons_result)) {

        while ($row = $lessons_result->fetch_assoc()) {
            $table_data = "<a style='color: black;'  href=../lesson/lesson.php?edit=" . $row['id'] . ">" . $row['lesson_name'] . "</a>" . "<br><small>" . $row['code'] . "</br>" . getlecbyid($db, $row['lecturer']) . "<br>" . getroombyid($db, $row['room']) . "<br></small>";
            // echo "<td>" . $row['lesson_name'] . "</td>";
        }
    }
    // echo ("data printed");
    return $table_data;
}
if (isset($_GET['notification'])) {
    notify_($db, "Bachelor of Information Technology", "Class postponed", "1");
}

function notify_($db, $title, $body, $key)
{
    define('API_ACCESS_KEY', 'AAAAnQRuWAM:APA91bEDnXmsHv7DSk0zzRFRbFytn9GGFRSJvE4avcF_eP9tMRVuetmwQSDrLQ9KzWCii7-aHUQ9eB3-W03Ce3djJ6xbt88rne18j4my4d1MzwV1wx1nvc1mAPxZW8tW9H02aPN5svfd');
    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    $token = 'cmYrgJOoRZqgR06Uyapt2w:APA91bEjp9PWhJwmnBL9h3hRsfbEmGNsCyvuJ0HeYTIb_IaiflwmU8JhNNHe4Knh1FaGgeyRjooI5ryjTGoIgjtPaO3bdM-cJ2BEiCulIICXWiD3AYmn9WJLvVL1frib397D7fphbaJ9';

    $examresult = $db->query("SELECT * FROM device_id") or die($db->error);
    $devices_response = array();
    while ($row = $examresult->fetch_assoc()) {
        // temp user array
        $devices = array();
        // $devices[] = $row["device_id"];

        // $lesson["color"] = $row["color"];
        // push single lesson into final response array
        array_push($devices_response, $row["device_id"]);
    }

    $notification = [
        'title' => $title,
        'body' => $body,
        'key_1' => $key,
        'icon' => "icon",
        'sound' => 'mySound',
        'timestamp' => date('Y-m-d G:i:s')
    ];
    $extraNotificationData = ["message" => $notification, "moredata" => 'dd'];

    $fcmNotification = [
        'registration_ids' => $devices_response, //multple token array
        // 'to'        => $token, //single token
        'data' => $extraNotificationData
        // 'data' => $extraNotificationData
    ];

    $headers = [
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fcmUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    $result = curl_exec($ch);
    curl_close($ch);


    // echo $result;
    // echo json_encode($devices_response[0]); 
}
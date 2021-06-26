<?php
include '../process/process.php';

use PHPMailer\PHPMailer\PHPMailer;

// GET TIMEABLE BY ID
if (isset($_GET['timetable_id'])) {
    $t_id = $_GET['timetable_id'];

    $result = $db->query("SELECT * FROM lesson where t_id='$t_id'") or die($db->error);
    $lesson_response = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $lesson = array();
        $lesson['id'] = $row['id'];
        $lesson['l_name'] = $row['lesson_name'];
        $lesson['l_code'] = $row['code'];
        $lesson['dep'] = getdepbyid($db, $row['department']);
        $lesson['course'] = $row['course'];
        $lesson['year'] = $row['year_of_study'];
        $lesson['semester'] = $row['semester'];
        $lesson['fragment'] = $row['fragment'];
        $lesson['lec'] = getlecbyid($db, $row['lecturer']);
        $lesson['room'] = getroombyid($db, $row['room']);
        $lesson['from'] = $row['from_time'];
        $lesson['to'] = $row['to_time'];
        $lesson['t_id'] = $row['t_id'];
        $lesson['lec_id'] = $row['lecturer'];
        $lesson['status'] = $row['status'];
        // $lesson['color'] = $row['color'];

        // push single lesson into final response array
        array_push($lesson_response, $lesson);
    }

    echo json_encode($lesson_response);
}

// GET ALL TIMETABLES

if (isset($_GET['timetable_all'])) {
    $result = $db->query('SELECT * FROM timetables ORDER BY course') or die($db->error);
    $timetables_response = array();
    while ($row = $result->fetch_assoc()) {
        $timetables = array();
        $timetables['id'] = $row['id'];
        $timetables['department'] = getdepbyid($db, $row['department']);
        $timetables['course'] = $row['course'];
        $timetables['year'] = $row['year'];
        $timetables['semester'] = $row['semester'];

        // PUT TIMETABLE DETAILS INTO AN ARRAY
        array_push($timetables_response, $timetables);
    }

    echo json_encode($timetables_response);
}

if (isset($_GET['getNoticesdep'])) {
    $depid = $_GET['getNoticesdep'];
    $result = $db->query("SELECT * FROM dep_notice where dep_id='$depid' type_='$getnotice_type' ORDER BY postdate") or die($db->error);
    $depnotice_response = array();
    while ($row = $result->fetch_assoc()) {
        $dep_notice = array();
        $dep_notice['id'] = $row['id'];
        $dep_notice['title'] = $row['title'];
        $dep_notice['content'] = $row['content'];
        $dep_notice['postdate'] = $row['postdate'];
        $dep_notice['dep_id'] = $row['dep_id'];

        // PUT TIMETABLE DETAILS INTO AN ARRAY
        array_push($depnotice_response, $dep_notice);
    }
    echo json_encode($depnotice_response);
}

if (isset($_GET['getNoticesclass'])) {
    $getid = $_GET['getNoticesclass'];
    $getnotice_type = $_GET['notice_type'];
    $get_lec = $_GET['lecturer'];
    $result;
    // echo $get_lec;
    if ($get_lec === '0') {
        $result = $db->query("SELECT * FROM class_notice where class_id='$getid' AND type_='$getnotice_type' ORDER BY postdate") or die($db->error);
    } else {
        $result = $db->query("SELECT * FROM class_notice where class_id='$getid' AND type_='$getnotice_type' AND lecturer='$get_lec' ORDER BY postdate") or die($db->error);
    }
    $classnotice_response = array();
    while ($row = $result->fetch_assoc()) {
        $classnotice = array();
        $classnotice['id'] = $row['id'];
        $classnotice['title'] = $row['title'];
        // $classnotice['due'] = $row['due'];
        $classnotice['submission'] = $row['submission'];
        $classnotice['content'] = $row['content'];
        $classnotice['type'] = $row['type_'];
        $seconds = $row['postdate'] / 1000;
        $classnotice['postdate'] = date("d/m/Y", $seconds);
        $classnotice['class_id'] = $row['class_id'];
        $classnotice['lecturer'] = getlecbyid($db, $row['lecturer']);

        // PUT TIMETABLE DETAILS INTO AN ARRAY
        array_push($classnotice_response, $classnotice);
    }
    echo json_encode($classnotice_response);
}



if (isset($_GET['dep_notice'])) {
}

// just a class notice
if (isset($_GET['class_notice'])) {
    $sc = '0';
    $title = $_GET['title'];
    $content = $_GET['content'];
    $postdate = $_GET['postdate'];
    $classid = $_GET['class_id'];
    $submission = '_';

    $db->query("INSERT INTO class_notice values(null,'$title','$submission','$content','notice','$postdate','$classid')") or die($db->error);
    $suc_response = array();
    $succ = array();
    $sc = '1';

    $succ['success'] = $sc;
    array_push($suc_response, $succ);
    echo json_encode($suc_response);
}
// update assignment
if(isset($_GET['update_ass'])){
    $sc = '0';
    $id = $_GET['id'];
    $title = $_GET['title'];
    $submission = $_GET['submission'];
    $content = $_GET['content'];
    $classid = $_GET['update_ass'];
    $type = "assignment";


    $stmt = $db->prepare('UPDATE class_notice SET title=?,submission=?,content=? WHERE id=?');
    echo $db->error;
    $stmt->bind_param('sssi', $title, $submission, $content, $id);
    // $stmt->execute();
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    else{
        notify_($db,"Assignment update",$title ." Update",$classid);
    }



    // $db->query( "INSERT INTO class_notice values(null,
    // '$title',
    // '$submission',
    // '$content',
    // 'assignment',
    // '$postdate',
    // '$classid')" ) or die( $db->error );
    $suc_response = array();
    $succ = array();
    $sc = '1';

    $succ['success'] = $sc;
    array_push($suc_response, $succ);
    echo json_encode($suc_response);
}
// insert assignmet
if (isset($_GET['assignment'])) {
    $sc = '0';
    $title = $_GET['title'];
    $submission = $_GET['submission'];
    $content = $_GET['content'];
    $postdate = $_GET['postdate'];
    $classid = $_GET['assignment'];
    $lecturer = $_GET['lecturer'];
    $type = "assignment";


    $stmt = $db->prepare('insert into class_notice (title,submission,content,lecturer,type_,postdate,class_id) VALUES(?,?,?,?,?,?,?)');
    echo $db->error;
    $stmt->bind_param('sssssss', $title, $submission, $content, $lecturer, $type, $postdate, $classid);
    // $stmt->execute();
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    else{
        notify_($db,"Assignment",$title,$classid);
    }



    // $db->query( "INSERT INTO class_notice values(null,
    // '$title',
    // '$submission',
    // '$content',
    // 'assignment',
    // '$postdate',
    // '$classid')" ) or die( $db->error );
    $suc_response = array();
    $succ = array();
    $sc = '1';

    $succ['success'] = $sc;
    array_push($suc_response, $succ);
    echo json_encode($suc_response);
}

// insert assignmet
if (isset($_POST['assignment'])) {
    $sc = '0';

    $title = $_POST['title'];
    $submission = $_POST['submission'];
    $content = $_POST['content'];
    $postdate = $_POST['postdate'];
    $classid = $_POST['assignment'];


    $db->query("INSERT INTO class_notice values(null,
    '$title',
    '$submission',
    '$content',
    'assignment',
    '$postdate',
    '$classid')") or die($db->error);

    $suc_response = array();
    $succ = array();
    $sc = '1';

    $succ['success'] = $sc;
    array_push($suc_response, $succ);
    echo json_encode($suc_response);
}

// GET EXAM TIMETABLE BY ID
if (isset($_GET['exam_id'])) {
    $t_id = $_GET['exam_id'];

    $result = $db->query("SELECT * FROM exam where t_id='$t_id'") or die($db->error);
    $exam_response = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $exams = array();
        $exams['id'] = $row['id'];
        $exams['e_name'] = $row['name'];
        $exams['e_code'] = $row['code'];
        $exams['dep'] = $row['department'];
        $exams['course'] = $row['course'];
        $exams['year'] = $row['year_of_study'];
        $exams['semester'] = $row['semester'];
        $exams['supervisor'] = getlecbyid($db, $row['supervisor']);
        $exams['date'] = $row['exam_date'];
        $exams['room'] = $row['room'];
        $exams['from'] = $row['from_time'];
        $exams['to'] = $row['to_time'];
        $exams['t_id'] = $row['t_id'];
        $exams['status'] = $row['status'];
        $exams['lec_id'] = $row['supervisor'];

        // $lesson['color'] = $row['color'];

        // push single lesson into final response array
        array_push($exam_response, $exams);
    }

    echo json_encode($exam_response);
}

// VIEW TIMETABLE WITHOUT GETTING IT

if (isset($_GET['vtimetable_id']) && isset($_GET['day'])) {
    $t_id = $_GET['vtimetable_id'];
    $day = $_GET['day'];

    $result = $db->query("SELECT * FROM lesson where t_id='$t_id' and fragment='$day'") or die($db->error);
    $lesson_response = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array

        $lesson = array();
        $lesson['id'] = $row['id'];
        $lesson['l_name'] = $row['lesson_name'];
        $lesson['l_code'] = $row['code'];
        $lesson['dep'] = getdepbyid($db, $row['department']);
        $lesson['course'] = $row['course'];
        $lesson['year'] = $row['year_of_study'];
        $lesson['semester'] = $row['semester'];
        $lesson['fragment'] = $row['fragment'];
        $lesson['lec'] = getlecbyid($db, $row['lecturer']);
        $lesson['room'] = getroombyid($db, $row['room']);
        $lesson['from'] = $row['from_time'];
        $lesson['to'] = $row['to_time'];
        $lesson['t_id'] = $row['t_id'];
        $lesson['status'] = $row['status'];
        $lesson['lec_id'] = $row['lecturer'];

        // $lesson['color'] = $row['color'];

        // push single lesson into final response array
        array_push($lesson_response, $lesson);
    }

    echo json_encode($lesson_response);
}

// login lecturer
if (isset($_GET['reg']) && isset($_GET['pass'])) {
    $reg = $_GET['reg'];
    $pass = $_GET['pass'];

    $success = '0';
    $lec_response = array();

    $result = $db->query("SELECT * FROM lecturer where email='$reg' and password='$pass'") or die($db->error);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $lec = array();
        $lec['id'] = $row['id'];
        $lec['success'] = '1';
        array_push($lec_response, $lec);
    } else {
        $lec['success'] = '0';
        array_push($lec_response, $lec);
    }

    echo json_encode($lec_response);
}

if (isset($_GET['postpone'])) {
    // $reg = $_GET['reg'];
    // $pass = $_GET['pass'];
    // change lesson status to postoned, insert lesson into postponed_table

    $sc = '0';
    $lid = $_GET['postpone'];
    $tid = $_GET['t_id'];
    $till = $_GET['till'];
    $db->query("update lesson set status='postponed' where id=$lid") or die($db->error);

    $db->query("INSERT INTO postponed_lesson values(null,$till,$lid,$tid)") or die($db->error);

    notify_($db, 'Bachelor of Information Technology', getlessonamebyid($db, $lid) . ' Class postponed', $tid);

    $suc_response = array();
    $succ = array();
    $sc = '1';

    $succ['success'] = $sc;
    array_push($suc_response, $succ);
    echo json_encode($suc_response);
}

if (isset($_GET['continue'])) {
    // $reg = $_GET['reg'];
    // $pass = $_GET['pass'];
    // change lesson status to postoned, insert lesson into postponed_table

    $sc = '0';
    $lid = $_GET['continue'];
    // $t_id = $_GET['t_id'];
    $succ = array();
    $suc_response = array();

    $tid = $_GET['t_id'];
    // $till = $_GET['till'];
    $db->query("update lesson set status='ongoing' where id=$lid") or die($db->error);

    notify_($db, 'Bachelor of Information Technology', getlessonamebyid($db, $lid) . ' Class resumed', $tid);

    $sc = '1';

    $succ['success'] = $sc;
    array_push($suc_response, $succ);
    echo json_encode($suc_response);
}

if (isset($_GET['postpone_exam'])) {
    // $reg = $_GET['reg'];
    // $pass = $_GET['pass'];
    // change lesson status to postoned, insert lesson into postponed_table

    $sc = '0';
    $eid = $_GET['postpone_exam'];
    // $tid = $_GET['t_id'];
    // $till = $_GET['till'];
    $db->query("update exam set status='postponed' where id=$eid") or die($db->error);

    // $db->query( "INSERT INTO postponed_lesson values(null,$till,$lid,$tid)" ) or die( $db->error );
    $suc_response = array();
    $succ = array();
    $sc = '1';
    $succ['success'] = $sc;
    array_push($suc_response, $succ);
    echo json_encode($suc_response);
}

if (isset($_GET['continue_exam'])) {
    // $reg = $_GET['reg'];
    // $pass = $_GET['pass'];
    // change lesson status to postoned, insert lesson into postponed_table

    $sc = '0';
    $eid = $_GET['continue_exam'];
    $succ = array();
    $suc_response = array();

    // $tid = $_GET['t_id'];
    // $till = $_GET['till'];
    $db->query("update exam set status='ongoing' where id=$eid") or die($db->error);
    $sc = '1';

    $succ['success'] = $sc;
    array_push($suc_response, $succ);
    echo json_encode($suc_response);
}

if (isset($_GET['chkupdate'])) {

    $tid = $_GET['chkupdate'];
    $result = $db->query("SELECT * FROM lesson where t_id='$tid'") or die($db->error);
    $lesson_response = array();
    // temp user array
    $lesson = array();
    while ($row = $result->fetch_assoc()) {
        $lesson['id'] = $row['id'];
        $lesson['l_name'] = $row['lesson_name'];
        $lesson['l_code'] = $row['code'];
        $lesson['dep'] = getdepbyid($db, $row['department']);
        $lesson['course'] = $row['course'];
        $lesson['year'] = $row['year_of_study'];
        $lesson['semester'] = $row['semester'];
        $lesson['fragment'] = $row['fragment'];
        $lesson['lec'] = getlecbyid($db, $row['lecturer']);
        $lesson['room'] = getroombyid($db, $row['room']);
        $lesson['from'] = $row['from_time'];
        $lesson['to'] = $row['to_time'];
        $lesson['t_id'] = $row['t_id'];
        $lesson['status'] = $row['status'];
        $lesson['lec_id'] = $row['lecturer'];

        // $lesson['color'] = $row['color'];
        // push single lesson into final response array
        array_push($lesson_response, $lesson);
    }
    // echo json_encode( $exam_response );

    echo json_encode($lesson_response);
}
if (isset($_GET['chkexamupdate'])) {

    $tid = $_GET['chkexamupdate'];
    $lesson = array();
    $examresult = $db->query("SELECT * FROM exam where t_id='$tid'") or die($db->error);
    $exam_response = array();
    while ($row = $examresult->fetch_assoc()) {
        // temp user array
        $exams = array();
        $exams['e_id'] = $row['id'];
        $exams['e_name'] = $row['name'];
        $exams['e_code'] = $row['code'];
        $exams['e_dep'] = $row['department'];
        $exams['e_course'] = $row['course'];
        $exams['e_year'] = $row['year_of_study'];
        $exams['e_semester'] = $row['semester'];
        $exams['e_supervisor'] = getlecbyid($db, $row['supervisor']);
        $exams['e_date'] = $row['exam_date'];
        $exams['e_room'] = $row['room'];
        $exams['e_from'] = $row['from_time'];
        $exams['e_to'] = $row['to_time'];
        $exams['e_t_id'] = $row['t_id'];
        $exams['e_status'] = $row['status'];
        $exams['e_lec_id'] = $row['supervisor'];

        // $lesson['color'] = $row['color'];

        // push single lesson into final response array
        array_push($exam_response, $exams);
    }
    // echo json_encode( $exam_response );

    echo json_encode($exam_response);
}

if (isset($_GET['testtime'])) {
    echo timestamptostr('1583980333');
    $now = new DateTime();
    $now->setTimezone(new DateTimeZone('UTC'));
    echo '<pre>' . $now->format('Y-m-d H:i:s');
    $nowtm = $now->getTimestamp();
    echo '<pre>' . timestamptostr($nowtm);
}
if (isset($_GET['feedback'])) {
    $feedback_type = $_GET['feedback'];
    $content = $_GET['content'];
    $lesson_id = $_GET['l_id'];
    $table_id = $_GET['t_id'];
    $lec_id = $_GET['lec_id'];
    $swapbuddy_id = $_GET['buddy_id'];
    $buddylesson_id = $_GET['buddylesson_id'];
    $fromtime = $_GET['fromtime'];
    $totime = $_GET['totime'];
    $replydate = 'not_resolved';
    $lec_department = getlec_depbyid($db, $lec_id);

    $setcontent;
    if ($feedback_type === 'Swap') {
        $fromtime = 0;
        $totime = 0;
        $setcontent = 'Requesting swap of a class with ';
    } elseif ($feedback_type == 'password') {
        $content = '0';
        $lesson_id = '0';
        $table_id = '0';
        $swapbuddy_id = '0';
        $buddylesson_id = 0;
        $fromtime = 0;
        $totime = 0;
        $now = new DateTime();
        $replydate = $now->format('Y-m-d H:i');
        $lec_result = $db->query("SELECT * from lecturer where id=$lec_id") or die($db->error);
        while ($row = $lec_result->fetch_assoc()) {
            $email = $row['email'];
            $password = $row['password'];
            send_mail_password($db, $email, $password);
        }
        $setcontent = getlecbyid($db, $lec_id) . ' Requesting password';
    } elseif ($feedback_type === 'email') {
        $lesson_id = '0';
        $table_id = '0';
        $swapbuddy_id = '0';
        $buddylesson_id = 0;
        $fromtime = 0;
        $totime = 0;
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/London'));
        $replydate = $now->format('Y-m-d H:i');
        $db->query("UPDATE lecturer set email='$content' where id=$lec_id");
        $setcontent = getlecbyid($db, $lec_id) . ' changed email to ' . $content;
    } elseif ($feedback_type === 'timechange') {
        $swapbuddy_id = '0';
        $buddylesson_id = 0;
        $setcontent = getlecbyid($db, $lec_id) .  ' requesting change of time to ' . $content;
    }

    $now = new DateTime();
    $now->setTimezone(new DateTimeZone('Europe/London'));
    // echo $now->format( 'Y-m-d H:i:s' );
    // MySQL datetime format
    // echo $now->getTimestamp();

    $nowtm = $now->getTimestamp();
    $db->query("INSERT into feedback values(null,
    '$setcontent',
    '$fromtime',
    '$totime',
    '$nowtm',
    '$replydate',
    '$feedback_type',
    '$lec_id',
    '$lesson_id',
    '$swapbuddy_id',
    '$buddylesson_id',
    '$table_id',
    '$lec_department'
    )") or die(mysqli_error($db));

    // $result = $db->query( 'select * from feedback' );
    // while( $row = $result->fetch_assoc() ) {
    //     $start = DateTime::createFromFormat( 'U', $row['received_date'] );

    //     echo '<pre>'.$start->format( 'Y-m-d H:i:s' ).'pre';
    // }

    $feedbackresponse = array();
    $sc = '1';
    $succ = array();
    $succ['success'] = $sc;
    array_push($feedbackresponse, $succ);
    echo json_encode($feedbackresponse);
}
if(isset($_GET['retrieve'])){
    send_mail_password($db,"niteric@gmail.com","1234");
}

function send_mail_password($db, $email, $password)
{
    // $activation = md5( uniqid( rand(), true ) );
    // $key = hash( 'joaat', uniqid( mt_rand(), true ) );
    $feedbackresponse = array();
    $succ = array();

    $msg = 'Your Timetable password is ' . $password;
    $message = '<html><body>';
    $message .= '<h1 style="color:#f40;">Hi !</h1>';
    $message .= '<p style="color:#080;font-size:18px;">Dear Sir/Madam, Your password has been retrieved succesfully. <strong>'. $password .'.</strong></h3></p>';
    $message .= '</body></html>';
    //PHPMailer Object
    $mail = new PHPMailer;

    $mail->IsSMTP();
    // enable SMTP
    // $mail->SMTPDebug = 2;
    // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;
    // authentication enabled
    $mail->SMTPSecure = 'tls';
    // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    // optional
    // used only when SMTP requires authentication
    $mail->SMTPAuth = true;
    $mail->Username = 'erickmaina29@students.ku.ac.ke';
    $mail->Password = 'q.sill..';

    //From email address and name
    $mail->From = 'erickmaina29@students.ku.ac.ke';
    $mail->FromName = 'Kenyatta University Timetable';

    //To address and name
    $mail->addAddress($email);
    //Recipient name is optional

    //Address to which recipient will reply
    // $mail->addReplyTo( 'reply@yourdomain.com', 'Reply' );

    //CC and BCC
    // $mail->addCC( 'cc@example.com' );
    // $mail->addBCC( 'bcc@example.com' );

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = 'Timetable password';
    $mail->Body = "<i>$message</i>";
    $mail->AltBody = 'You are receiving this email from Timetable admin. if it was not You please ingore this message. Thank You.';
    $mail->send();

    if (!$mail->send()) {
        $succ['success'] = 'Server error occured, try again later';
        array_push($feedbackresponse, $succ);
        echo json_encode($feedbackresponse);
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        // echo 'Message has been sent successfully';
        $succ['success'] = 'Your password has been retrieved succesfully. Check your email'.$email;
        array_push($feedbackresponse, $succ);
        echo json_encode($feedbackresponse);
        // header( 'location: ../feedback/feedback.php' );
    }
}

if (isset($_GET['device_id'])) {
    $device_id = $_GET['device_id'];

    $result = $db->query("SELECT * FROM device_id where device_id='$device_id'") or die($db->error);
    if ($result->num_rows == 0) {
        $db->query("INSERT INTO device_id values(null,'$device_id')") or die($db->error);
    } else {
        echo 'id_exist';
    }
}

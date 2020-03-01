<!-- WEEK_ID + " INTEGER PRIMARY KEY AUTOINCREMENT,"
+ WEEK_SUBJECT + " TEXT,"
+ WEEK_FRAGMENT + " TEXT,"
+ WEEK_TEACHER + " TEXT,"
+ WEEK_ROOM + " TEXT,"
+ WEEK_FROM_TIME + " TEXT,"
+ WEEK_TO_TIME + " TEXT,"
+ WEEK_COLOR + " INTEGER,"
+ WEEK_MILI + " INTEGER" + ")"; -->


<!DOCTYPE html>
<html>
<?php
include '../process/process.php';
include '../logout/checklogin.php';

check_login();
$_SESSION['page'] = '../exams/exams.php';

?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Exams</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
  <!-- 
  <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css">


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</head>

<body>

  <?php
  include "../includes/nav.php";
  ?>

  <? if (isset($_GET['error'])) {
  alert("invalid time input start time");
  $error_msg = "invalid time start time is less than end time";
  } elseif (isset($_GET['error_lecoccupied'])) {
  $error_msg = "Lecturer will not be available at that particular time(" . $_GET['error_lecoccupied'] . ")";
  } elseif (isset($_GET['error_roomoccupied'])) {
  $error_msg = "Room will be occupied at that particular time (" . $_GET['error_roomoccupied'] . ")";
  } elseif (isset($_GET['error_timeoccupied'])) {
  $error_msg = "There will be an exam in progress at that particular time(" . $_GET['error_timeoccupied'] . ")";
  }

  ?>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <?php include "../includes/sidebar.php" ?>
    <!-- /#sidebar-wrapper -->

    <? if (isset($_GET['error'])) {
      alert("invalid time input start time");
    } ?>
    <!-- Page Content -->
    <div id="page-content-wrapper" style="padding: 0%; margin-left: 10%; margin-top: 0%;">

      <div class="">
        <div class="page-content-wrapper container" style="padding: 0%;  margin-top: 3%;">
          <h3>Exams TimeTable</h3>
          <hr>

          <div class="row">
            <div class="col">
              <?php
              // show add exam button
              if (empty($_SESSION['exam_add_open']))
              // isset($_GET['addexam']) || isset($_GET['editexam']) || isset($_GET['saved']) 
              {
              ?>
                <a href="../process/process.php?addexam" class="btn btn-outline-primary btn-sm">Add Exam</a>
              <?php } ?>

            </div>

            <div class="col d-flex flex-row justify-content-end">
              <div class="dropdown" style="margin-right:5px; margin-bottom: 5px;">
                <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <!-- dropdown header-->
                  <?php
                  if (empty($_SESSION['lcourse'])) {
                    echo "Select course";
                  } else {
                    echo $_SESSION['lcourse'];
                  } ?>


                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <?php
                  $dept = $_SESSION['ldep_name'];
                  if (!empty($_SESSION['lcourse'])) {
                    $ltablecourse = $_SESSION['lcourse'];
                  } else {
                    $ltablecourse = '';
                  }


                  $lesson_course = $db->query("select * from courses where department='$dept';");
                  while ($row = $lesson_course->fetch_assoc()) {  ?>

                    <a class="dropdown-item" href="../process/process.php?select_course=<?php echo $row['course_name']; ?>"><?php echo $row['course_name'] ?></a>
                  <?php } ?>
                </div>
              </div>
              <!-- button select year -->
              <div class="dropdown" style="margin-right:5px; margin-bottom: 5px;">
                <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php if (empty($_SESSION['lcourse']) || empty($_SESSION['year'])) {
                    echo "Select year";
                  } else {

                    echo $_SESSION['year'];
                  }; ?>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">

                  <?php if (!empty($_SESSION['year'])) {
                    $lyear = $_SESSION['year'];
                  } else {
                    $lyear = '';
                  } ?>
                  <a class="dropdown-item" href="../process/process.php?yearone">Year 1</a>
                  <a class="dropdown-item" href="../process/process.php?yeartwo">Year 2</a>
                  <a class="dropdown-item" href="../process/process.php?yearthree">Year 3</a>
                  <a class="dropdown-item" href="../process/process.php?yearfour">Year 4</a>
                  <a class="dropdown-item" href="../process/process.php?yearfive">Year 5</a>
                  <a class="dropdown-item" href="../process/process.php?yearsix">Year 6</a>

                </div>
              </div>
              <div class="dropdown" style=" margin-bottom: 5px;">
                <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php if (empty($_SESSION['semester']) || empty($_SESSION['lcourse']) || empty($_SESSION['year'])) {
                    echo "Select sem";
                  } else {

                    echo $_SESSION['semester'];
                  }; ?>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">

                  <?php if (!empty($_SESSION['semester'])) {
                    $lsemester = $_SESSION['semester'];
                  } else {
                    $lsemester = '';
                  } ?>
                  <a class="dropdown-item" href="../process/process.php?semone">Semester 1</a>
                  <a class="dropdown-item" href="../process/process.php?semtwo">Semester 2</a>
                  <a class="dropdown-item" href="../process/process.php?semthree">Semester 3</a>

                </div>
              </div>
            </div>
          </div>

          <hr>

          <!-- inputs start -->
          <div class="row">

            <?php

            if (!empty($_SESSION['exam_add_open']) && $_SESSION['exam_add_open'])
            // isset($_GET['addexam']) || isset($_GET['editexam']) || isset($_GET['saved']) 
            {
            ?>
              <div class="col">
                <?php
                include "addexam.php";
                ?>
              </div>
              <div class="col-sm-4">
                <?php include "exam_course.php"; ?>
              </div>
            <?php }
            ?>
          </div>

          <!-- input end -->

          <!-- table zone -->

          <?php
          if (!empty($_SESSION['exam_add_open']) && $_SESSION['exam_add_open'])
          // isset($_GET['addexam']) || isset($_GET['editexam']) || isset($_GET['saved']) 
          {
          } else {
            include "exam_table.php";
          }
          ?>

        </div>
      </div>
    </div>
  </div>
  <!-- /#page-content-wrapper -->
</body>


</html>
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
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lessons</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

    <!-- <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css">


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="../js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script> -->

</head>

<body>
    <?php
    include "../includes/nav.php";
    ?>

    <div class="d-flex" id="wrapper">
        <?php
        if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) { } else {
            include "../includes/sidebar.php";
        }
        ?>

        <!-- Page Content -->


        <div id="page-content-wrapper" style="padding: 0%; margin-bottom: 0%; margin-top: 0%;">


            <div class="container  page-content-wrapper">
                <div class="row">

                    <div class="col" style="width: 50%;">
                        <?php
                        include 'addlesson.php';

                        ?></div>
                    <div class="col">
                        <!-- hide and unhide add lesson button -->
                        <div class="" style="width: 100%;"><?php
                                                            if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) { ?>
                            <?php  } else { ?>
                                <a href="../lesson/lesson.php?addlesson" id="addlbtn" type="hidden" class="btn btn-outline-primary" style="margin-top: 2%; margin-bottom: 2%;">Add Lesson</a>

                            <?php } ?>
                            <a href="../lesson/lesson.php?print" type="hidden" class="btn btn-outline-primary" style="margin-top: 2%; margin-bottom: 2%;">Print view</a>



                        </div>


                        <!-- buttton select course and year -->

                        <div>
                            <div class="dropdown" style="margin-right: 10px; margin-bottom: 5px;">
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
                                    $dept = $_SESSION['ldep'];
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
                            <div class="dropdown" style="margin-right: 10px; margin-bottom: 5px;">
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
                        </div>








                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>MONDAY</th>
                                    <th>TUESDAY</th>
                                    <th>WEDNESDAY</th>
                                    <th>THURSDAY</th>
                                    <th>FRIDAY</th>


                                </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <!-- NAME -->
                                    <td class="h6">
                                        <?php
                                        $lessons_result_monday = $db->query("select * from lesson where fragment='monday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                        if (!empty($lessons_result_monday)) {

                                            while ($row = $lessons_result_monday->fetch_assoc()) {
                                                // echo $row['lesson_name'];



                                                echo $row['lesson_name']; ?>
                                                <br><br>
                                                Time:
                                                <?php echo $row['from_time']; ?> - <?php echo $row['to_time']; ?>
                                                <br><br>
                                                Lecturer: <?php echo $row['lecturer']; ?>
                                                <br><br>
                                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                            <?php }
                                        } ?>

                                    </td>
                                    <!-- CODE -->
                                    <td class="h6">
                                        <?php

                                        $lessons_result_tuesday = $db->query("select * from lesson where fragment='tuesday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                        if (!empty($lessons_result_tuesday)) {
                                            while ($row = $lessons_result_tuesday->fetch_assoc()) {
                                                // echo $row['lesson_name'];
                                                echo $row['lesson_name']; ?>
                                                <br><br>
                                                Time:
                                                <?php echo $row['from_time']; ?> - <?php echo $row['to_time']; ?>
                                                <br><br>
                                                Lecturer: <?php echo $row['lecturer']; ?>
                                                <br><br>
                                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                            <?php }
                                        } ?>
                                    </td>
                                    <!-- COURSE -->
                                    <td class="h6">
                                        <?php
                                        $lessons_result_wednesday = $db->query("select * from lesson where fragment='wednesday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                        if (!empty($lessons_result_wednesday)) {

                                            while ($row = $lessons_result_wednesday->fetch_assoc()) {
                                                // echo $row['lesson_name'];

                                                echo $row['lesson_name']; ?>
                                                <br><br>
                                                Time:
                                                <?php echo $row['from_time']; ?> - <?php echo $row['to_time']; ?>
                                                <br><br>
                                                Lecturer: <?php echo $row['lecturer']; ?>
                                                <br><br>
                                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                            <?php }
                                        } ?>
                                    </td>

                                    <!-- SEMESTER -->
                                    <td class="h6">
                                        <?php
                                        $lessons_result_thursday = $db->query("select * from lesson where fragment='thursday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                        if (!empty($lessons_result_thursday)) {

                                            while ($row = $lessons_result_thursday->fetch_assoc()) {
                                                // echo $row['lesson_name'];
                                                echo $row['lesson_name']; ?>
                                                <br><br>
                                                Time:
                                                <?php echo $row['from_time']; ?> - <?php echo $row['to_time']; ?>
                                                <br><br>
                                                Lecturer: <?php echo $row['lecturer']; ?>
                                                <br><br>
                                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                            <?php }
                                        } ?>
                                    </td>
                                    <!-- supervisor -->
                                    <td class="h6">
                                        <?php
                                        $lessons_result_friday = $db->query("select * from lesson where fragment='friday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                        if (!empty($lessons_result_friday)) {

                                            while ($row = $lessons_result_friday->fetch_assoc()) {
                                                // echo $row['lesson_name'];
                                                echo $row['lesson_name']; ?>
                                                <br><br>
                                                Time:
                                                <?php echo $row['from_time']; ?> - <?php echo $row['to_time']; ?>
                                                <br><br>
                                                Lecturer: <?php echo $row['lecturer']; ?>
                                                <br><br>
                                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                            <?php }
                                        } ?>
                                    </td>

                                </tr>


                            </tbody>

                        </table>



                        <!-- Tables start -->
                        <div class="border d-flex flex-row bd-highlight mb-6">


                            <table class="table table-bordered">

                                <thead>
                                    <tr>
                                        <th>Monday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $lessons_result_monday = $db->query("select * from lesson where fragment='monday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                    if (!empty($lessons_result_monday)) {

                                        while ($row = $lessons_result_monday->fetch_assoc()) {
                                            // echo $row['lesson_name'];

                                            ?>
                                            <tr>
                                                <td class="h6"><?php echo $row['lesson_name']; ?>
                                                    <br><br>
                                                    Time:<?php echo $row['from_time']; ?>-<?php echo $row['to_time']; ?>
                                                    <br><br>
                                                    Lecturer: <?php echo $row['lecturer']; ?>
                                                    <br><br>
                                                    <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                    <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                                </td>
                                            <?php  }
                                        }
                                        ?>
                                    </tr>


                                </tbody>

                            </table>



                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tuesday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $lessons_result_tuesday = $db->query("select * from lesson where fragment='tuesday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                    if (!empty($lessons_result_tuesday)) {
                                        while ($row = $lessons_result_tuesday->fetch_assoc()) {
                                            // echo $row['lesson_name'];

                                            ?>
                                            <tr>
                                                <td class="h6"><?php echo $row['lesson_name']; ?>
                                                    <br><br>
                                                    Time:<?php echo $row['from_time']; ?>-<?php echo $row['to_time']; ?>
                                                    <br><br>
                                                    Lecturer: <?php echo $row['lecturer']; ?>
                                                    <br><br>
                                                    <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                    <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                                </td>
                                            <?php  }
                                        } ?>
                                    </tr>


                                </tbody>

                            </table>



                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Wednesday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $lessons_result_wednesday = $db->query("select * from lesson where fragment='wednesday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                    if (!empty($lessons_result_wednesday)) {

                                        while ($row = $lessons_result_wednesday->fetch_assoc()) {
                                            // echo $row['lesson_name'];

                                            ?>
                                            <tr>
                                                <td class="h6"><?php echo $row['lesson_name']; ?>
                                                    <br><br>
                                                    Time:<?php echo $row['from_time']; ?>-<?php echo $row['to_time']; ?>
                                                    <br><br>
                                                    Lecturer: <?php echo $row['lecturer']; ?>
                                                    <br><br>
                                                    <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                    <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                                </td>
                                            <?php  }
                                        } ?>
                                    </tr>


                                </tbody>

                            </table>




                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Thursday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $lessons_result_thursday = $db->query("select * from lesson where fragment='thursday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                    if (!empty($lessons_result_thursday)) {

                                        while ($row = $lessons_result_thursday->fetch_assoc()) {
                                            // echo $row['lesson_name'];

                                            ?>
                                            <tr>
                                                <td class="h6"><?php echo $row['lesson_name']; ?>
                                                    <br><br>
                                                    Time:<?php echo $row['from_time']; ?>-<?php echo $row['to_time']; ?>
                                                    <br><br>
                                                    Lecturer: <?php echo $row['lecturer']; ?>
                                                    <br><br>
                                                    <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                    <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                                </td>
                                            <?php  }
                                        } ?>
                                    </tr>


                                </tbody>

                            </table>



                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Friday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $lessons_result_friday = $db->query("select * from lesson where fragment='friday' and department='$dept' and course='$ltablecourse' and year_of_study='$lyear';");
                                    if (!empty($lessons_result_friday)) {

                                        while ($row = $lessons_result_friday->fetch_assoc()) {
                                            // echo $row['lesson_name'];

                                            ?>
                                            <tr>
                                                <td class="h6"><?php echo $row['lesson_name']; ?>
                                                    <br><br>
                                                    Time:<?php echo $row['from_time']; ?>-<?php echo $row['to_time']; ?>
                                                    <br><br>
                                                    Lecturer: <?php echo $row['lecturer']; ?>
                                                    <br><br>
                                                    <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                                    <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Delete</a>
                                                </td>
                                            <?php  }
                                        } ?>
                                    </tr>


                                </tbody>

                            </table>


                        </div>
                    </div>





                    <div class="row justify-content-center">
                        <?php
                        if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) {
                            include 'addlesson.php';
                        }
                        ?>
                    </div>
                    <!-- input end -->


                </div>
                <!-- /#page-content-wrapper -->
            </div>
        </div>

    </div>
</body>

</html>
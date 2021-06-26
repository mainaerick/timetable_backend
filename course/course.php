<!DOCTYPE html>
<html lang="en">
<?php
include '../process/process.php';
include '../logout/checklogin.php';
check_login();
$_SESSION['page'] = '../course/course.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Courses</title>
</head>

<body>
    <?php include "../includes/nav.php"; ?>



    <div class="d-flex" id="wrapper">
        <?php
        // if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) {

        // }
        // else{
        include "../includes/sidebar.php";

        // }
        ?>

        <!-- Page Content -->


        <div id="page-content-wrapper" style="padding: 0%; margin-left: 10%; margin-top: 0%;">


            <div class="container page-content-wrapper" style="padding: 0%;  margin-top: 3%;">

                <h3>Courses</h3>



                <hr>
                <div class="row">

                    <div class="col">
                        <!-- <button id="addlbtn" class=" btn btn-outline-primary btn-sm">Add Lesson</button> -->
                        <?php
                        if (empty($_SESSION['course_add_open'])) {
                            // isset($_GET['addlesson']) || isset($_GET['edit']) ||

                        ?>
                            <a id="addcbtn" href="../process/process.php?addcourse" type="hidden" class="btn btn-outline-primary btn-sm">Add Course</a>

                            <hr>
                        <?php }
                        ?>
                    </div>




                </div>



                <div class="row justify-content-center">

                    <?php
                    if (!empty($_SESSION['course_add_open']) && $_SESSION['course_add_open']) {
                        // isset($_GET['addlesson']) || isset($_GET['edit']) ||

                    ?>
                        <div class="col-sm-2">
                            <?php  ?>
                        </div>
                        <div class="col">
                            <?php
                            include 'addcourse.php';
                            // }
                            // else if(!empty($_SESSION['unit_add_open']) && $_SESSION['unit_add_open']){
                            //     include 'addunit.php';

                            // }
                            ?>
                        </div>
                        <div class="col-sm-2">
                            <?php  ?>
                        </div>
                    <?php


                    } else if (!empty($_SESSION['unit_add_open']) && $_SESSION['unit_add_open']) {
                    ?>
                        <div class="col-sm-2">
                            <?php  ?>
                        </div>
                        <div class="col">
                            <?php
                        include 'addunit.php';
                            // }
                            // else if(!empty($_SESSION['unit_add_open']) && $_SESSION['unit_add_open']){
                            //     include 'addunit.php';

                            // }
                            ?>
                        </div>
                        <div class="col-sm-2">
                            <?php  ?>
                        </div>
                    <?php


                    }
                    ?>
                </div>
                <!-- input end -->

                <!-- hide and unhide add lesson button -->


                <!-- buttton select course and year -->




                <!-- TABLE -->


                <?php
                if (!empty($_SESSION['course_add_open']) && ($_SESSION['course_add_open'])|| !empty($_SESSION['unit_add_open']) && $_SESSION['unit_add_open']) {
                }
                 else {
                    include "tablecourse.php";
                }
                ?>

                <!-- TABLE END -->
            </div>
            <!-- /#page-content-wrapper -->

        </div>

    </div>
</body>

</html>
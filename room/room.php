<!DOCTYPE html>
<html lang="en">
<?php
include '../process/process.php';
include '../logout/checklogin.php';
check_login();
$_SESSION['page'] = '../room/room.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rooms</title>
</head>

<body>
    <?php include "../includes/nav.php"; ?>



    <div class="d-flex" id="wrapper">
        <?php
        // if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) {

        // }
        // else{
        include "../includes/sidebar_admin.php";

        // }
        ?>

        <!-- Page Content -->


        <div id="page-content-wrapper" style="padding: 0%; margin-left: 10%; margin-top: 0%;">
            <div class="container page-content-wrapper" style="padding: 0%;  margin-top: 3%;">

                <h3>Manage Rooms</h3>
                <hr>
                <div class="row">

                    <div class="col">
                        <!-- <button id="addlbtn" class=" btn btn-outline-primary btn-sm">Add Lesson</button> -->
                        <?php
                        if (empty($_SESSION['room_add_open'])) {
                            // isset($_GET['addlesson']) || isset($_GET['edit']) ||

                        ?>
                            <a id="addrbtn" href="../process/process.php?add_room" type="hidden" class="btn btn-outline-primary btn-sm">Add Room</a>

                            <hr>
                        <?php }
                        ?>
                    </div>




                </div>



                <div class="row justify-content-center">

                    <?php
                    if (!empty($_SESSION['room_add_open']) && $_SESSION['room_add_open']) {
                    // isset($_GET['addlesson']) || isset($_GET['edit']) ||

                    ?>
                    <div class="col-sm-2">
                        <?php  ?>
                    </div>
                    <div class="col">
                        <?php
                        include 'addroom.php';
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
                if (!empty($_SESSION['room_add_open']) && ($_SESSION['room_add_open'])) {
                } else {
                    include "viewroom.php";
                }
                ?>

                <!-- TABLE END -->
            </div>
            <!-- /#page-content-wrapper -->

        </div>

    </div>
</body>

</html>
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
$_SESSION['page'] = '../lesson/lesson.php';

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
        // if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) {

        // }
        // else{
        include "../includes/sidebar.php";

        // }
        ?>
        <? if (isset($_GET['error'])) {
            alert("invalid time input start time");
            $error_msg = "invalid time start time is less than end time";
        } elseif (isset($_GET['error_lecoccupied'])) {
            $error_msg = "Lecturer will not be available at that particular time(" . $_GET['error_lecoccupied'] . ")";
        } elseif (isset($_GET['error_roomoccupied'])) {
            $error_msg = "Room will be occupied at that particular time (" . $_GET['error_roomoccupied'] . ")";
        } elseif (isset($_GET['error_timeoccupied'])) {
            $error_msg = "There will be a lesson in progress at that particular time(" . $_GET['error_timeoccupied'] . ")";
        }

        ?>

        <!-- Page Content -->


        <div id="page-content-wrapper" style="padding: 0%; margin-left: 10%; margin-top: 0%;">


            <div class="container page-content-wrapper" style="padding: 0%;  margin-top: 3%;">
                <div class="d-flex col justify-content-center">
                    <!-- <button type="button" class="btn btn-outline-secondary"></button> -->


                    <?php
                    if (empty($_SESSION['ldep_name'])) {
                        echo '<h5><span class="badge badge-pill badge-secondary">' . "Please select a department" . '</span></h5>';
                    } else {
                        echo '<h5><span class="badge badge-pill badge-secondary">' . $_SESSION['ldep_name'] . '</span></h5>';
                    } ?>



                </div>
                <div class="d-flex col justify-content-center">
                    <?php
                    if (empty($_SESSION['lcourse'])) {
                    } else {
                        echo '<h4>' . $_SESSION['lcourse'] . ' TIMETABLE</h4>';
                    } ?>

                    <h4> </h4>

                </div>

                <!-- Search form -->


                <div class="search_result d-flex col">
                    <div class="result row"></div>
                    <div class="dep_avail row" style="color: red;">
                        <?php
                        if (empty($_SESSION['no_dep'])) {
                        } else {
                            echo $_SESSION['no_dep'];
                        } ?>
                    </div>
                </div>



                <!-- <p class="d-flex col justify-content-end"></p> -->



                <hr>
                <div class="row">
                    <div class="col">
                        <!-- <button id="addlbtn" class=" btn btn-outline-primary btn-sm">Add Lesson</button> -->
                        <?php
                        if (empty($_SESSION['lesson_add_open'])) {
                            // isset($_GET['addlesson']) || isset($_GET['edit']) ||

                        ?>
                            <a id="addlbtn" href="../process/process.php?addlesson" type="hidden" class="btn btn-outline-primary btn-sm">Add Lesson</a>
                        <?php } ?>
                    </div>

                    <div class="d-flex col justify-content-end">

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
                                // $dept = $_SESSION['ldep']; //department id
                                $dept_name = $_SESSION['ldep_name']; //department name


                                if (!empty($_SESSION['lcourse'])) {
                                    $ltablecourse = $_SESSION['lcourse'];
                                } else {
                                    $ltablecourse = '';
                                }


                                $lesson_course = $db->query("select * from courses where department='$dept_name';");

                                if (!empty($lesson_course)) {
                                    while ($row = $lesson_course->fetch_assoc()) {  ?>

                                        <a class="dropdown-item" href="../process/process.php?select_course=<?php echo $row['course_name']; ?>"><?php echo $row['course_name'] ?></a>
                                    <?php }
                                } else {
                                    ?>
                                    <a class="dropdown-item disabled" href="#">No available Courses</a>
                                <?php
                                } ?>
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


                <div class="row">

                    <?php
                    if (!empty($_SESSION['lesson_add_open']) && $_SESSION['lesson_add_open']) {
                        // isset($_GET['addlesson']) || isset($_GET['edit']) ||

                    ?>
                        <div class="col">
                            <?php
                            include 'addlesson.php';
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php include 'listlessons_available.php' ?>
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
                if (!empty($_SESSION['lesson_add_open']) && ($_SESSION['lesson_add_open'])) {
                } else {
                    include "table_lesson.php";
                }
                ?>

                <!-- TABLE END -->
            </div>
            <!-- /#page-content-wrapper -->

        </div>

    </div>

    <div class="search_result d-flex col">
        <div class="result row"></div>
        <div class="dep_avail row" style="color: red;">
            <?php
            if (empty($_SESSION['no_dep'])) {
            } else {
                echo $_SESSION['no_dep'];
            } ?>
        </div>
    </div>

    <script type="text/javascript" src="../js/script.js"> </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.searching .col .search-box input[type="text"]').on("keyup input", function() {
                /* Get input value on change */
                var inputVal = $(this).val();
                var resultDropdown = $('.result');
                // $(this).siblings(".result");
                var availdep = $(this).siblings(".dep_avail");
                if (inputVal.length) {
                    $.post("../process/process.php", {
                        dep_search: inputVal
                    }).done(function(data) {
                        // Display the returned data in browser
                        resultDropdown.html(data);
                        availdep.text("");
                    });
                } else {
                    resultDropdown.empty();
                }
            });

            // Set search input value on click of result item
            $(document).on("click", ".result a", function() {
                $(".searching .col .search-box").find('input[type="text"]').val($(this).text());
                $(this).parents(".result").empty();
            });
        });
    </script>



    <!-- 

    <script type="text/javascript">
        $(document).ready(function() {
            $("#search").keyup(function() {
                var dep_search = $(this).val();
                if (dep_search != "") {

                    $.ajax({
                        url: '../process/process.php',
                        method: 'POST',
                        data: {
                            dep_search: dep_search
                        },
                        success: function(data) {

                            var i;
                            for (i = 0; i < data.length; i++) {
                                $('#output').html(data);
                            }
                            $('#output').css('display', 'block');

                            $("#search").focusout(function() {
                                $('#output').css('display', 'none');
                            });
                            $("#search").focusin(function() {
                                $('#output').css('display', 'block');
                            });
                        }
                    });
                } else {
                    $('#output').css('display', 'none');
                }
            });
        });
    </script> -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_lesson').click(function() {
                var name = $('#name').val();
                var manager = $('#manager').val();
                var address = $('#address').val();
                var phone = $('#phone').val();


                // alert(brands);
                $.ajax({
                    url: "add_warehouse.php",
                    type: "POST",
                    data: {
                        name: name,
                        manager: manager,
                        address: address,
                        phone: phone
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('.add_new_warehouse').modal('hide');

                    }
                });

                $('#warehouse_form').trigger('reset');
            });

            setInterval(function() {
                $('#table_content').load('fetch_warehouse.php');
            }, 200);
        });


        $(document).on('click', '#delete_warehouse', function() {
            var ids = $(this).data('id');
            // alert(ids);
            $.ajax({
                url: "delete_warehouse.php",
                type: "post",
                data: "warehouse_id=" + ids,
                success: function(data) {
                    $('.delete_warehouse').modal('hide');
                }
            });
        });
    </script>
</body>

</html>
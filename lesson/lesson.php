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
require_once '../process/process.php';
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
        <?php
        if (!empty($_SESSION['lsaveddata'])) {
            $editlessonname = $_SESSION['lsaveddata'][0];
            $editfragment = $_SESSION['lsaveddata'][1];
            $editlecturer = $_SESSION['lsaveddata'][2];
            $editroom = $_SESSION['lsaveddata'][3];
            $editfromtime = $_SESSION['lsaveddata'][4];
            $edittotime = $_SESSION['lsaveddata'][5];
            $editlessoncode = $_SESSION['lsaveddata'][6];
            $editlessoncourse = $_SESSION['lsaveddata'][7];
            $editlessonsemester = $_SESSION['lsaveddata'][8];
            $editlessonyear = $_SESSION['lsaveddata'][9];
            $editlec_reg = $_SESSION['lsaveddata'][10];
            $edit_stdno = $_SESSION['lsaveddata'][11];
            unset($_SESSION['lsaveddata']);
        }

        if (isset($_GET['error'])) {
            // alert("invalid time input start time");
            $error_msg = "invalid time start time is less than end time";
        } elseif (isset($_GET['error_lecoccupied'])) {
            $error_msg = "Lecturer will not be available at that particular time(" . $_GET['error_lecoccupied'] . ")";
        } elseif (isset($_GET['error_roomoccupied'])) {
            $error_msg = "Room will be occupied at that particular time (" . $_GET['error_roomoccupied'] . ")";
        } elseif (isset($_GET['error_timeoccupied'])) {
            $error_msg = "There will be a lesson in progress at that particular time(" . $_GET['error_timeoccupied'] . ")";
        } elseif (isset($_GET['hour_exceed'])) {
            $error_msg = "Lecture has reached its maximum teaching hours";
        } elseif (isset($_GET['lesson_exist_not'])) {
            $error_msg = "Unit does not exist";
        }

        ?>

        <!-- Page Content -->


        <div id="page-content-wrapper" style="padding: 0%; margin-left: 10%; margin-top: 0%;">

            <div class="container page-content-wrapper" style="padding: 0%;  margin-top: 3%;">


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
                <div class="row">
                    <h3 class="col">Class TimeTable</h3>



                    <div class="d-flex col justify-content-end">

                        <div class="dropdown" style="margin-right:5px; margin-bottom: 5px;">
                            <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

                                <a class="dropdown-item"
                                    href="../process/process.php?select_course=<?php echo $row['course_name']; ?>&course_id=<?php echo $row['id']; ?>"><?php echo $row['course_name'] ?></a>
                                <?php }
                                } else {
                                    ?>
                                <a class="dropdown-item disabled" href="#">No available Courses</a>
                                <?php
                                    $ure = $db->query("select from units where course=" + $_GET['course_id']) or die($db->error);
                                    alert("");
                                } ?>
                            </div>
                        </div>

                        <!-- button select year -->
                        <div class="dropdown" style="margin-right:5px; margin-bottom: 5px;">
                            <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <div class="col">
                        <?php
                        if (empty($_SESSION['lesson_add_open'])) {
                            // isset($_GET['addlesson']) || isset($_GET['edit']) ||

                        ?>
                        <a id="addlbtn" href="../process/process.php?addlesson" type="hidden"
                            class="btn btn-outline-primary btn-sm">Add Lesson</a>
                        <?php } ?>
                    </div>
                    <!-- <button id="addlbtn" class=" btn btn-outline-primary btn-sm">Add Lesson</button> -->

                </div>
                <hr>

                <div class="row">

                    <?php
                    if (!empty($_SESSION['lesson_add_open']) && $_SESSION['lesson_add_open']) {
                        // isset($_GET['addlesson']) || isset($_GET['edit']) ||
                    ?>
                    <div class="col-sm-6">
                        <?php
                            include 'addlesson.php';
                            ?>
                    </div>
                    <div class="col-sm-6" id="side_view">
                        <?php
                            include 'lecturer_available.php';
                            ?>
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
                    if (isset($_GET['printlesson'])) {
                        include "print_table.php";
                    } else {
                        include "table_lesson.php";
                    }
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


    <script>
    function changeFunc(id) {
        // var id = $(this).data('id');
        // alert(id);
        swal({
                title: "Confirm to delete",
                text: "info cannot be recovered once deleted",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            // function() {
            // $.ajax({
            //     method: "GET",
            //     url: '../process/process.php',
            //     data: 'delete=' + id,
            //     dataType: 'json',
            //     beforeSend : () => {

            //     },
            //     success: function(data) {
            //         swal("Ajax request finished!");

            //     }
            //     ,complete: () => {

            //     },
            //     error : ()=>{
            //         alert("an error occoured")
            //     }
            // });

            function() {
                setTimeout(function() {
                    $.ajax({
                        method: "GET",
                        url: '../process/process.php',
                        data: 'delete=' + id,
                        dataType: 'json',
                        beforeSend: () => {

                        },
                        success: function(data) {
                            swal("Ajax request finished!");

                        },
                        complete: () => {
                            window.location.href = "../lesson/lesson.php";
                        },
                        error: () => {

                        }
                    });
                    swal("Ajax request finished!");
                }, 2000);
            });
    }
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

    <script>
    // function myFunction() {
    //     // Declare variables
    //     var input, filter, table, tr, td, i, j, txtValue, selected_value, td_count
    //     input = document.getElementById("search_lessons");
    //     filter = input.value.toUpperCase();
    //     // table = document.getElementById("prtable_lessons");
    //     // tr = table.getElementsByTagName("tr");
    //     // selected_value = document.getElementById("select_filter").value;
    //     // Loop through all table rows, and hide those who don't match the search query
    //     for (i = 0; i < tr.length; i++) {
    //         for (j = 0; j < tr[i].getElementsByTagName("td").length; j++) {
    //             td = tr[i].getElementsByTagName("td")[j];
    //             // td = tr[i].getElementById("td-department")[0];
    //             if (td) {
    //                 txtValue = td.textContent || td.innerText;
    //                 // alert(txtValue);
    //                 if (txtValue.toUpperCase().indexOf(filter) > -1) {
    //                     tr[i].getElementsByTagName("td")[j].style.display = "";
    //                 } else {
    //                     tr[i].getElementsByTagName("td")[j].style.display = "none";
    //                 }
    //             }
    //         }
    //     }
    // }

    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function lecmyFunction() {
        document.getElementById("lecDropdown").classList.toggle("show");
    }

    function filterFunctionlec() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInputlec");
        filter = input.value.toUpperCase();
        div = document.getElementById("lecDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }

    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }

    function onchangefilter(filtervalue) {
        var selected_value = document.getElementById("select_filter").value; //column
        if (selected_value == "room") {
            document.getElementById("select_filter_lecturer").style.display = "none";
            document.getElementById("select_filter_room").style.display = "block";


        } else if (selected_value == "lecturer") {
            document.getElementById("select_filter_lecturer").style.display = "block";
            document.getElementById("select_filter_room").style.display = "none";
        }
    }

    function filterselected(id) {
        var selected_value = document.getElementById("select_filter").value; //column

        location.href = 'print_schooltimetable.php?filter_value=' + id + "&col_value=" + selected_value;
    }
    </script>
</body>

</html>
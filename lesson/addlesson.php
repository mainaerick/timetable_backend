<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <div style="margin-bottom: 3px;">

    </div>
    <form id="form_lesson" class="w-100 p-7 border" style="padding: 5%; margin-bottom: 5%; margin-top: 2%;" action="../process/process.php" method="POST">

        <div style="margin-bottom: 3px;" class="row">
            <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->
            <button class="btn btn-outline-primary btn-sm" role="group" aria-label="Third group">
                <? echo $error_msg; ?></button>

        </div>


        <div style="margin-bottom: 3px;" class="row justify-content-end">
            <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->
            <a class="btn btn-outline-secondary btn-sm" href="../lesson/lesson.php?doneaddlesson" role="group" aria-label="Third group" style="">Close</a>

        </div>

        <input type="hidden" value="<?php echo $id ?>" name="id">
        <div class="form-group row">
            <label class="col-sm-4" for="subject">Lesson Name</label>
            <input type="text" class="col-sm-8 form-contro l form-control-sm" id="subject" name="lesson_name" value="<?php echo $editlessonname; ?>" placeholder="name of the lesson" required>

        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="subject">Lesson Code</label>
            <input type="text" class="col-sm-8 form-control form-control-sm" id="lcode" name="lesson_code" value="<?php echo $editlessoncode; ?>" placeholder="code of the lesson" required>

        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="subject">Course</label>
            <select class="col-sm-8 form-control form-control-sm" name="lcourse" value="" id="select_course">
                <option selected><?php
                                    if (isset($_GET['edit'])) {
                                        echo $editlessoncourse;
                                    } else {

                                        if (empty($_SESSION['lcourse'])) {
                                        } else {
                                            echo $_SESSION['lcourse'];
                                        }
                                    }
                                    ?></option>

                <?php
                $dept = $_SESSION['ldep_name'];
                $add_lesson_course = $db->query("select * from courses where department='$dept';");
                while ($row = $add_lesson_course->fetch_assoc()) {  ?>
                    <option><?php echo $row['course_name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="year_ofstudy">Year of study</label>
            <select class="col-sm-8 form-control form-control-sm" name="lesson_year" id="lyear">
                <option selected><?php if (isset($_GET['edit'])) {
                                        echo $editlessonyear;
                                    } else {
                                        if (empty($_SESSION['year'])) {
                                        } else {
                                            echo $_SESSION['year'];
                                        }
                                    } ?></option>
                <option>Year 1</option>
                <option>Year 2</option>
                <option>Year 3</option>
                <option>Year 4</option>
                <option>Year 5</option>
                <option>Year 6</option>



            </select>
        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="subject">Semester</label>
            <select class="col-sm-8 form-control form-control-sm" name="lesson_semester" value="<?php echo $editlessonsemester; ?>" id="lsemester">
                <option selected>
                    <?php if (isset($_GET['edit'])) {
                        echo $editlessonsemester;
                    } else {

                        if (empty($_SESSION['semester'])) {
                        } else {
                            echo $_SESSION['semester'];
                        }
                    } ?>
                </option>
                <option>Semester 1</option>
                <option>Semester 2</option>
                <option>Semester 3</option>
            </select>
        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="dayselect">Select Day</label>
            <select class="col-sm-8 form-control form-control-sm" name="fragment" value="<?php echo $editfragment; ?>" onchange="changeFunc();" id="dayselectBox" placeholder="day the lesson will be held">
                <option selected><?php echo $editfragment; ?></option>
                <option>Monday</option>
                <option>Tuesday</option>
                <option>Wednesday</option>
                <option>Thursday</option>
                <option>Friday</option>
            </select>
        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="lecturer">Lecturer</label>
            <input type="text" class="col-sm-8 form-control form-control-sm" id="lecturer" name="lecturer" value="<?php echo $editlecturer; ?>" placeholder="name of the lecturer" required>
        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="room">Room</label>
            <input type="text" class="col-sm-8 form-control form-control-sm" id="room" name="room" value="<?php echo $editroom; ?>" placeholder="place the lesson to be held at" required>
        </div>





        <?
        include "../time_test.php";
        ?>







        <div class="form-group row">
            <div class="col-sm-4"> <label for="fromtime">From</label>
                <input type="time" class="form-control form-control-sm" name="fromtime" value="<?php echo $editfromtime; ?>" placeholder="From Time" id="fromtime" required>
            </div>
            <div class="col-sm-4"> <label for="totime">To</label>
                <input type="time" class="form-control form-control-sm" style="border-color:blue;" name="totime" value="<?php echo $edittotime; ?>" placeholder="To Time" id="totime" required>
            </div>
            <div class="col-sm-4">
                <label for="time_slots">Free time slots</label>
                <select class="form-control form-control-sm" name="time_slots" id="timeslot">
                
                </select>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="form-group">
                    <?php if ($update == false) { ?>
                        <input class="btn btn-outline-success" type="submit" name="save_lesson" value="Add">
                    <?php } else { ?>
                        <input class="btn btn-outline-success" type="submit" name="update" value="Update">
                    <?php }
                    ?>
                
                    includes/sidebar.php
                </div>

            </div>
        </div>


    </form>

    <!-- input end -->

    <Script>
        // select _day to view time free
        function changeFunc() {
            var selectBox = document.getElementById("dayselectBox");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;

            var selectBox_couse = document.getElementById("select_course");
            var selectedcourse = selectBox_couse.options[selectBox_couse.selectedIndex].value;

            var selectBox_year = document.getElementById("lyear");
            var selectedyear = selectBox_year.options[selectBox_year.selectedIndex].value;

            var selectBox_sem = document.getElementById("lsemester");
            var selectedsemester = selectBox_sem.options[selectBox_sem.selectedIndex].value;

            $.ajax({
                method: "GET",
                url: '../process/process.php',
                data: {
                    timeslots: selectedValue,
                    course_name: selectedcourse,
                    selected_year: selectedyear,
                    selected_semester: selectedsemester
                },

                success: function(data) {
                    $('#timeslot').empty();
                    // swal("Ajax request finished!");
                    var json_data = JSON.parse(data);
                    for (var key in json_data) {
                        $('#timeslot').append('<option value="">' + json_data[key] + '</option>');


                    }


                },
                complete: (data) => {
                    // alert(data.responseText);

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                    // document.getElementById("dayselectBox").innerHTML(xhr)

                    alert(thrownError);
                }
            });
        }
    </Script>

</body>

</html>
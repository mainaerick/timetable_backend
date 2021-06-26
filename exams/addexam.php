<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form class="w-100 p-7 border" style="padding: 5%; margin-bottom: 5%; margin-top: 2%;" action="" method="post">

        <div style="margin-bottom: 3px;" class="row">
            <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->
            <div class="col">
                <button class="btn btn-outline-primary btn-sm" role="group" aria-label="Third group">
                    <? echo $error_msg; ?></button>
            </div>

            <div class="col">
                <div style="margin-bottom: 3px;" class="row justify-content-end">
                    <a href="../exams/exams.php?hide_exam_add" class="btn btn-outline-secondary btn-sm" role="group" aria-label="Third group">Hide</a>
                </div>
                <div style="margin-bottom: 3px;" class="row justify-content-end">
                    <a href="../exams/exams.php" class="btn btn-outline-secondary btn-sm" role="group" aria-label="Third group">Available units</a>
                </div>
            </div>
        </div>



        <div class="form-group row">
            <div class="col-sm-4">
                <label>Exam dates</label>
            </div>

            <div class="col-sm-4">
                <label for="fromdate">From date</label>
                <input type="date" onchange="SetUserName()" class="col-sm-8 form-control form-control-sm" id="fromdate" name="fromdate" value="<?
                if (empty($_SESSION['exam_fromdate'])) {
                } else {
                    echo $_SESSION['exam_fromdate'];
                }?>">
            </div>

            <div class="col-sm-4">
                <label for="todate">To date</label>
                <input onchange="autoexamchangeFunc()" type="date" class="col-sm-8 form-control form-control-sm" id="todate" name="todate" value="<?
                if (empty($_SESSION['exam_todate'])) {
                } else {
                    echo $_SESSION['exam_todate'];
                }?>">
            </div>

        </div>

        <div class="row justify-content-end">
            <input type="hidden" value="<?php echo $id ?>" name="exam_id">
        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="examname">Unit name</label>
            <input type="text" readonly list="datalesson" class="col-sm-8 form-control form-control-sm" id="examname" name="examname" value="<?php echo $editexamname; ?>" placeholder="name of the exam" required>
            <datalist id="datalesson">
                <?php if (empty($_SESSION['semester']) || empty($_SESSION['lcourse']) || empty($_SESSION['year'])) {
                } else {
                    $dept = $_SESSION['ldep_name'];
                    $ltablecourse = $_SESSION['lcourse'];
                    $lyear = $_SESSION['year'];
                    $lsemester = $_SESSION['semester'];
                    $datalist_lesson = $db->query("select * from lesson where department='$dept' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                    if (!empty($datalist_lesson)) {
                        while ($row = $datalist_lesson->fetch_assoc()) {
                ?>
                            <option><?php echo $row['lesson_name'];
                                    $_SESSION['lesson_code'] = $row['code'];

                                    ?></option>
                <?php
                        }
                    }
                } ?>
            </datalist>
        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="examcode">Unit code</label>
            <input type="text" readonly class="col-sm-8 form-control form-control-sm" id="examcode" name="examcode" value="<?php echo $editexamcode; ?>" placeholder="code of the exam" required>
            <input type="hidden" value="<?php echo $edit_stdno ?>" name="std_no" id="std_no">

        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="examcourse">Course</label>
            <select class="col-sm-8" class="form-control form-control-sm" name="examcourse" id="lcourse">

                <option selected><?php
                                    if (isset($_GET['editexam'])) {
                                        echo $editexamcourse;
                                    } else {
                                        if (empty($_SESSION['lcourse'])) {
                                        } else {
                                            echo $_SESSION['lcourse'];
                                        }
                                    }
                                    ?></option>

                <?php
                $dept = $_SESSION['ldep'];
                $add_lesson_course = $db->query("select * from courses where department='$dept';");
                while ($row = $add_lesson_course->fetch_assoc()) {  ?>
                    <option><?php echo $row['course_name'] ?></option>
                <?php } ?>
            </select>

        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="year_ofstudy">Year of study</label>
            <select class="col-sm-8 form-control form-control-sm" name="examyear" id="lyear">
                <option selected><?php if (isset($_GET['editexam'])) {
                                        echo $editexamyear;
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
            <select class="col-sm-8 form-control form-control-sm" name="examsemester" value="<?php echo $editlessonsemester; ?>" id="lsemester">
                <option selected>
                    <?php if (isset($_GET['editexam'])) {
                        echo $editexamsemester;
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
            <label class="col-sm-4" for="lecturer">Lecture in charge</label>
            <input type="text" readonly class="col-sm-8 form-control form-control-sm" id="examsupervisor" name="examsupervisor" value="<?php echo $editexamsupervisor; ?>" placeholder="name of lead supervisor" required>
            <input type="hidden" readonly class="col-sm-8 form-control form-control-sm" id="examsupervisor_reg" name="examsupervisor_reg" value="<?php echo $editexamsupervisor_reg; ?>" placeholder="Reg of lead supervisor" required>

        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="dateselect">Select date</label>
            <input onchange="examchangeFunc()" type="date" class="col-sm-8 form-control form-control-sm" id="seleceddate" name="examdate" value="<?php echo $editexamdate; ?>" placeholder="Date of the exam" required>
        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="lecturer">Room</label>
            <input type="text" class="col-sm-5 form-control form-control-sm" id="room" name="examroom" value="<?php echo $editexamroom; ?>" placeholder="location of the exam" required>
            <input type="text" class="col-sm-3 form-control form-control-sm" id="stdno" name="stdno" placeholder="No. of students" value="<?php echo $exam_roomcapacity; ?>">

        </div>

        <div class="form-group row">

            <div class="col-sm-4" id="fromtimepicker">
                <label for="fromtime">From</label>
                <input type="text" data-format="HH:mm PP" class="form-control form-control-sm add-on" placeholder="From Time" id="fromtime" readonly name="examfromtime" value="<?php echo $editexamfromtime; ?>" required>
            </div>

            <div class="col-sm-4" id="totimepicker">
                <label for="totime">To</label>
                <input type="text" data-format="HH:mm PP" class="form-control form-control-sm add-on" readonly placeholder="To Time" id="totime" name="examtotime" value="<?php echo $editexamtotime; ?>" required>
            </div>

            <div class="col-sm-4">
                <label for="time_slots">Free time slots</label>
                <select class="form-control form-control-sm" name="time_slots" id="examtimeslot" onchange="gettimetimeslotexam()">
                </select>
            </div>

        </div>

        <div class="form-group row">
            <?php if ($update == false) { ?>
                <input class="btn btn-outline-primary" type="submit" name="save_exam" value="Add">
            <?php } else { ?>
                <input class="btn btn-outline-primary" type="submit" name="update_exam" value="Update">
            <?php }
            ?>
        </div>

    </form>
    <script>
        function examchangeFunc() {
            var selectBox = document.getElementById("seleceddate");
            var selectedValue = selectBox.value; //input date

            var fromdateinput = document.getElementById("fromdate");
            var fromdatevalue = fromdateinput.value;

            var todateinput = document.getElementById("todate");
            var todatevalue = todateinput.value;


            var selectBox_couse = document.getElementById("lcourse");
            var selectedcourse = selectBox_couse.options[selectBox_couse.selectedIndex].value;


            var selectBox_year = document.getElementById("lyear");
            var selectedyear = selectBox_year.options[selectBox_year.selectedIndex].value;

            var selectBox_sem = document.getElementById("lsemester");
            var selectedsemester = selectBox_sem.options[selectBox_sem.selectedIndex].value;
            // alert(selectedsemester);

            // var radiobuttom = $('input[type=radio].form-check-input:checked');
            // var radio_value;

            // $(radiobuttom).each(function(i) {
            //     radio_value = $(this).val()

            // });
            $.ajax({
                method: "GET",
                url: '../process/process.php',
                data: {
                    fromdate: fromdatevalue,
                    todate: todatevalue,
                    exams_timeslots: selectedValue,
                    examcourse: selectedcourse,
                    examyear: selectedyear,
                    examsemester: selectedsemester
                    // radio_value_text: radio_value
                },

                success: function(data) {
                    $('#examtimeslot').empty();
                    // swal("Ajax request finished!");
                    // alert(data);

                    var json_data = JSON.parse(data);


                    for (var key in json_data) {
                        if (json_data[key] ==
                            "please select a course, year and semester then select day to view free timeslots"
                        ) {
                            alert(
                                "Please select a course, year and semester\nThen select day to view free timeslots"
                            );
                        } else {
                            $('#examtimeslot').append('<option value="' + json_data[key] + '">' + json_data[
                                key] + '</option>');

                            var inputfromtime = document.getElementById("fromtime");
                            var inputtotime = document.getElementById("totime");
                            from_time = json_data[0].substr(0, json_data[0].indexOf("-"));
                            totime = json_data[0].substr(json_data[0].indexOf("-") + 1, json_data[0].length);
                            inputfromtime.value = from_time;
                            inputtotime.value = totime;
                        }


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


        // AUTO ALLOCATION
        function autoexamchangeFunc() {
            var fromdateinput = document.getElementById("fromdate");
            var fromdatevalue = fromdateinput.value;

            var todateinput = document.getElementById("todate");
            var todatevalue = todateinput.value;

            var selectBox_couse = document.getElementById("lcourse");
            var selectedcourse = selectBox_couse.options[selectBox_couse.selectedIndex].value;


            var selectBox_year = document.getElementById("lyear");
            var selectedyear = selectBox_year.options[selectBox_year.selectedIndex].value;

            var selectBox_sem = document.getElementById("lsemester");
            var selectedsemester = selectBox_sem.options[selectBox_sem.selectedIndex].value;
            // alert(selectedsemester);

            // var radiobuttom = $('input[type=radio].form-check-input:checked');
            // var radio_value;

            // $(radiobuttom).each(function(i) {
            //     radio_value = $(this).val()

            // });
            $.ajax({
                method: "GET",
                url: '../process/process.php',
                data: {
                    fromdate: fromdatevalue,
                    todate: todatevalue,
                    autoexams_timeslots: 'selectedValue',
                    examcourse: selectedcourse,
                    examyear: selectedyear,
                    examsemester: selectedsemester
                    // radio_value_text: radio_value
                },

                success: function(data) {
                    $('#examtimeslot').empty();
                    // swal("Ajax request finished!");
                    // alert(data);

                    var json_data = JSON.parse(data);


                    for (var key in json_data) {
                        if (json_data[key] ==
                            "please select a course, year and semester then select day to view free timeslots"
                        ) {
                            alert(
                                "Please select a course, year and semester\nThen select day to view free timeslots"
                            );
                        } else {
                            // $('#examtimeslot').append('<option value="' + json_data[key] + '">' + json_data[key] + '</option>');

                            var inputfromtime = document.getElementById("fromtime");
                            var inputtotime = document.getElementById("totime");
                            var inputdate = document.getElementById("seleceddate");

                            from_time = json_data[0].substr(0, json_data[0].indexOf("-"));
                            totime = json_data[0].substr(json_data[0].indexOf("-") + 1, json_data[0].indexOf(
                                ";"));
                            autodate = json_data[0].substr(json_data[0].indexOf(";") + 1, json_data[0].length);
                            inputfromtime.value = from_time;
                            inputtotime.value = totime;
                            inputdate.value = autodate;
                        }


                    }
                    examchangeFunc();



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
        $(document).ready(function() {
            autoexamchangeFunc();
        });
    </script>
</body>

</html>
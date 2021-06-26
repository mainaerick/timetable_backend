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
    <form id="form_lesson" class="border" style="width:100%; padding: 5%; margin-bottom: 5%;"
        action="../process/process.php" method="POST">
        <div class="row">
            <div class="col">
                <div style="margin-bottom: 3px;" class="col">
                    <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->
                    <button class="btn btn-outline-primary btn-sm" role="group" aria-label="Third group">
                        <? echo $error_msg; ?>
                    </button>

                </div>
                <div style="margin-bottom: 3px;" class="col">
                    <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->
                    <button class="btn btn-outline-primary btn-sm" role="group" aria-label="Third group">
                        <? if (!empty($_SESSION['timechange'])) {
                            echo $_SESSION['timechange'];
                        }
                        ?>
                    </button>

                </div>
            </div>
            <div class="col">
                <div style="margin-bottom: 3px;" class="row justify-content-end">
                    <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->
                    <a class="btn btn-outline-secondary btn-sm" href="../lesson/lesson.php?doneaddlesson" role="group"
                        aria-label="Third group">Close</a>
                </div>

            </div>
        </div>




        <input type="hidden" value="<?php echo $id ?>" name="id">
        <div class="form-group row">
            <label class="col-sm-4" for="subject">Lesson Name</label>
            <input type="text" class="col-sm-7 form-control form-control-sm " onkeypress="return false;" id="subject"
                name="lesson_name" value="<?php echo $editlessonname; ?>" placeholder="name of the lesson" required>
        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="subject">Lesson Code</label>
            <input type="text" onkeypress="return false;" class="col-sm-7 form-control form-control-sm" id="lcode"
                name="lesson_code" value="<?php echo $editlessoncode; ?>" placeholder="code of the lesson" required>
            <input type="hidden" value="<?php echo $edit_stdno ?>" name="std_no" id="std_no">

        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="subject">Course</label>
            <select class="col-sm-7 form-control form-control-sm" name="lcourse" value="" id="select_course">
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
            <select class="col-sm-7 form-control form-control-sm" name="lesson_year" id="lyear">
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
            <select class="col-sm-7 form-control form-control-sm" name="lesson_semester"
                value="<?php echo $editlessonsemester; ?>" id="lsemester">
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
            <select class="col-sm-7 form-control form-control-sm" name="fragment" value="<?php echo $editfragment; ?>"
                id="dayselectBox" placeholder="day the lesson will be held">
                <!-- onchange="changeFunc()" -->
                <option selected>
                    <? if ($editfragment === '') { ?>
                    Monday
                    <? } else {
                                        echo $editfragment;
                                    } ?>
                </option>
                <?
                if ($editfragment === '') { ?>
                Monday
                <? } else { ?>
                <option>Monday</option>
                <? } ?>

                <option>Tuesday</option>
                <option>Wednesday</option>
                <option>Thursday</option>
                <option>Friday</option>
            </select>
        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="lecturer">Lecturer</label>
            <input type="text" onkeypress="return false;" onkeyup="searchlecturer_l()"
                class="col-sm-7 form-control form-control-sm" id="lecturer" name="lecturer"
                value="<?php echo $editlecturer; ?>" placeholder="name of the lecturer" required>
            <input type="hidden" value="<?php echo $editlec_reg ?>" name="lec_reg" id="lec_reg">

        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="room">Room</label>
            <input type="text" onkeypress="return false;" onkeyup="searchroom_l()"
                class="col-sm-3 form-control form-control-sm" id="room" name="room" value="<?php echo $editroom; ?>"
                placeholder="place the lesson to be held at" required>
            <input type="text" class="col-sm-4 form-control form-control-sm" id="stdno" name="stdno"
                placeholder="Number of students">
        </div>

        <?
        // include "../time_test.php";
        ?>

        <div class="form-group row">
            <label class="col-sm-4" for="dayselect">Select Type</label>
            <div class="col-sm-2">
                <input class="form-check-input" type="radio" name="exampleRadios" onclick="changeFunc_timeslot()"
                    id="single_l" value="single">
                <label class="form-check-label" for="single_l">
                    Single lesson
                </label></input>
            </div>

            <div class="col-sm-2">
                <input class="form-check-input" type="radio" name="exampleRadios" onclick="changeFunc_timeslot()"
                    id="double_l" value="double">
                <label class="form-check-label" for="double_l">
                    Double lesson
                </label>
            </div>

            <div class="col-sm-2">
                <input class="form-check-input" type="radio" name="exampleRadios" onclick="changeFunc_timeslot()"
                    id="tripple_l" value="tripple">
                <label class="form-check-label" for="tripple_l">
                    Tripple lesson
                </label>
            </div>
        </div>
        <div class="form-group row">

            <div class="col-sm-4" id="fromtimepicker">
                <label for="fromtime">From</label>
                <input type="text" data-format="HH:mm PP" class="form-control form-control-sm add-on"
                    onkeypress="return false;" name="fromtime" value="<?php echo $editfromtime; ?>"
                    placeholder="From Time" id="fromtime" required>
            </div>

            <div class="col-sm-4" id="totimepicker">
                <label for="totime">To</label>
                <input type="text" data-format="HH:mm PP" class="form-control form-control-sm add-on"
                    onkeypress="return false;" style="border-color:blue;" name="totime"
                    value="<?php echo $edittotime; ?>" placeholder="To Time" id="totime" required>
            </div>

            <div class="col-sm-4">
                <label for="time_slots">Free time slots</label>
                <select class="form-control form-control-sm" name="time_slots" id="timeslot"
                    onchange="gettimeromtimeslot()">
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

                </div>

            </div>
        </div>


    </form>

    <!-- input end -->

    <Script>
    $(document).ready(function() {
        var recordCount = 2;
        $("#subject").click(function() {


            recordCount = recordCount + 2;
            $.ajax({
                type: "GET",
                url: "../process/process.php?units",
                data: {},
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    var trHTML = '';
                    // $('#table_units').empty();

                    $.each(response, function(i, item) {
                        // alert(item.name);
                        trHTML += '<tr class="tr_unitavailable"><td class="name">' +
                            item.name + '</td><td class="code">' + item.code +
                            '</td><td class="std_no">' + item.stud_no +
                            '</td></tr>';
                    });
                    $('#table_units').append(trHTML);

                    // $.get('units_avail.php', function(data) {
                    //     $('#side_view').html(data);
                    //     // alert(data);
                    // });
                },
                error: function(e) {
                    console.log(response);
                }
            });
        });
    });

    // // room input_click
    // $(document).ready(function() {
    //     var recordCount = 2;
    //     $("#room").click(function() {

    //         recordCount = recordCount + 2;
    //         $.ajax({
    //             type: "GET",
    //             url: "../process/process.php?rooms",
    //             data: {},
    //             contentType: "application/json; charset=utf-8",
    //             dataType: "json",
    //             cache: false,
    //             success: function(response) {
    //                 var trHTML = '';
    //                 $('#table_room').empty();

    //                 $.each(response, function(i, item) {
    //                     // alert(item.name);
    //                     trHTML += '<tr class="tr_roomavailable"><td class="room_name">' + item.name + '</td><td class="">' + item.capacity +
    //                         '</td></tr>';
    //                 });
    //                 $('#table_room').append(trHTML);
    //             },
    //             error: function(e) {
    //                 console.log(response);
    //             }
    //         });
    //     });
    // });

    // lec input_click
    $(document).ready(function() {
        var recordCount = 2;

        $("#lecturer").click(function() {
            recordCount = recordCount + 2;
            $.ajax({
                type: "GET",
                url: "../process/process.php?lecturer",
                data: {},
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    var trHTML = '';
                    // $('#table_lec').empty();
                    $.each(response, function(i, item) {
                        // alert(item.name);
                        trHTML +=
                            '<tr class="tr_lecavailable"><td class="lec_name">' +
                            item.name +
                            '</td><td class="lec_reg">' + item.email +
                            '</td></tr>';
                    });
                    $('#table_lec').append(trHTML);
                },
                error: function(e) {
                    // console.log(response);
                }
            });
        });
    });
    // select _day to view time free
    function changeFunc_timeslot() {
        var selectBox = document.getElementById("dayselectBox");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;

        var selectBox_couse = document.getElementById("select_course");
        var selectedcourse = selectBox_couse.options[selectBox_couse.selectedIndex].value;

        var selectBox_year = document.getElementById("lyear");
        var selectedyear = selectBox_year.options[selectBox_year.selectedIndex].value;

        var selectBox_sem = document.getElementById("lsemester");
        var selectedsemester = selectBox_sem.options[selectBox_sem.selectedIndex].value;
        var radiobuttom = $('input[type=radio].form-check-input:checked');
        var radio_value;

        $(radiobuttom).each(function(i) {
            radio_value = $(this).val()

        });
        $.ajax({
            method: "GET",
            url: '../process/process.php',
            data: {
                timeslots: selectedValue,
                course_name: selectedcourse,
                selected_year: selectedyear,
                selected_semester: selectedsemester,
                radio_value_text: radio_value
            },

            success: function(data) {
                $('#timeslot').empty();
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
                        var inputfromtime = document.getElementById("fromtime");
                        var inputtotime = document.getElementById("totime");
                        from_time = json_data[0].substr(0, json_data[0].indexOf("-"));
                        totime = json_data[0].substr(json_data[0].indexOf("-") + 1, json_data[0].length);
                        inputfromtime.value = from_time;
                        inputtotime.value = totime;

                        $('#timeslot').append('<option value="' + json_data[key] + '">' + json_data[key] +
                            '</option>');

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

    function gettimeromtimeslot() {
        var selectBox = document.getElementById("timeslot");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        var inputfromtime = document.getElementById("fromtime");
        var inputtotime = document.getElementById("totime");

        var from_time, totime;
        from_time = selectedValue.substr(0, selectedValue.indexOf("-"));
        totime = selectedValue.substr(selectedValue.indexOf("-") + 1, selectedValue.length);
        inputfromtime.value = from_time;
        inputtotime.value = totime;
        // alert(from_time + "-" + totime);
    }
    </Script>




</body>

</html>
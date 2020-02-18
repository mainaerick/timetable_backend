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
            <button class="btn btn-outline-primary btn-sm" role="group" aria-label="Third group">
                <? echo $error_msg; ?></button>

        </div>
        
        <div style="margin-bottom: 3px;" class="row justify-content-end">
            <a href="../exams/exams.php?hide_exam_add" class="btn btn-outline-secondary btn-sm" role="group" aria-label="Third group" style="">Hide</a>
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

        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="examcourse">Course</label>
            <select class="col-sm-8" class="form-control form-control-sm" name="examcourse" id="exampleFormControlSelect1">

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
        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="dateselect">Select date</label>
            <input type="date" class="col-sm-8 form-control form-control-sm" id="seleceddate" name="examdate" value="<?php echo $editexamdate; ?>" placeholder="Date of the exam" required>
        </div>

        <div class="form-group row">
            <label class="col-sm-4" for="lecturer">Room</label>
            <input type="text" class="col-sm-8 form-control form-control-sm" id="lecturer" name="examroom" value="<?php echo $editexamroom; ?>" placeholder="lacation of the exam" required>
        </div>

        <div class="form-group row">

            <div class="col-sm-6">
                <label for="fromtime">From</label>
                <input type="time" class="form-control form-control-sm" placeholder="From Time" id="datetimepicker3" name="examfromtime" value="<?php echo $editexamfromtime; ?>" required>
            </div>

            <div class="col-sm-6">
                <label for="totime">To</label>
                <input type="time" class="form-control form-control-sm time-picker" placeholder="To Time" id="totime" name="examtotime" value="<?php echo $editexamtotime; ?>" required>
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

</body>

</html>
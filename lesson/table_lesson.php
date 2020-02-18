<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <!-- Tables start -->
    <div class="flex-row justify-content-start" style="width: 100%;">

        <!-- <a href="../lesson/lesson.php?addlesson" id="addlbtn" type="hidden" class="btn btn-outline-primary" style="margin-top: 2%; margin-bottom: 2%;">Add Lesson</a> -->


        <a href="../lesson/lesson.php?print" type="hidden" class="btn btn-outline-primary btn-sm" style="margin-top: 2%; margin-bottom: 2%;">Print view</a>



    </div>

    <div id="hidden" class="">


        <table class="table table-sm table-bordered">
            <thead class="thead-dark">
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
                    <td class="text-lg">
                        <?php
                        $lessons_result_monday = $db->query("select * from lesson where fragment='monday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                        if (!empty($lessons_result_monday)) {

                            while ($row = $lessons_result_monday->fetch_assoc()) {
                                // echo $row['lesson_name'];



                                echo $row['lesson_name']; ?>
                                <br><br>

                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br><br>

                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>

                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <button class="btn btn-sm btn-outline-primary btn-delete" onclick="changeFunc(<?php echo $row['id']; ?>);" data-id="<?php echo $row['id']; ?>">Delete</button>


                                <br>
                                <br>
                        <?php }
                        } ?>

                    </td>
                    <!-- CODE -->
                    <td class="h6">
                        <?php

                        $lessons_result_tuesday = $db->query("select * from lesson where fragment='tuesday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                        if (!empty($lessons_result_tuesday)) {
                            while ($row = $lessons_result_tuesday->fetch_assoc()) {
                                // echo $row['lesson_name'];
                                echo $row['lesson_name']; ?>
                                <br><br>
                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br><br>
                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>
                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Delete</a>
                                <!-- <hr> -->
                        <?php }
                        } ?>
                    </td>
                    <!-- COURSE -->
                    <td class="h6">
                        <?php
                        $lessons_result_wednesday = $db->query("select * from lesson where fragment='wednesday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                        if (!empty($lessons_result_wednesday)) {

                            while ($row = $lessons_result_wednesday->fetch_assoc()) {
                                // echo $row['lesson_name'];

                                echo $row['lesson_name']; ?>
                                <br><br>
                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br><br>
                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>
                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Delete</a>
                                <!-- <hr> -->
                        <?php }
                        } ?>
                    </td>

                    <!-- SEMESTER -->
                    <td class="h6">
                        <?php
                        $lessons_result_thursday = $db->query("select * from lesson where fragment='thursday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                        if (!empty($lessons_result_thursday)) {

                            while ($row = $lessons_result_thursday->fetch_assoc()) {
                                // echo $row['lesson_name'];
                                echo $row['lesson_name']; ?>
                                <br><br>
                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br><br>
                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>
                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Delete</a>
                                <!-- <hr> -->
                        <?php }
                        } ?>
                    </td>
                    <!-- supervisor -->
                    <td class="h6">
                        <?php
                        $lessons_result_friday = $db->query("select * from lesson where fragment='friday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                        if (!empty($lessons_result_friday)) {

                            while ($row = $lessons_result_friday->fetch_assoc()) {
                                // echo $row['lesson_name'];
                                echo $row['lesson_name']; ?>
                                <br><br>
                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br><br>
                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>
                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>

                                <button class="btn btn-outline-primary btn-delete" data-id=" <?php echo $row['id']; ?>">Delete</button>
                                <!-- <hr> -->
                        <?php }
                        } ?>
                    </td>

                </tr>


            </tbody>

        </table>


    </div>



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
</body>

</html>
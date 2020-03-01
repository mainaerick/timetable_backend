<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>


    <script>
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, j, txtValue, selected_value, td_count
            input = document.getElementById("search_lessons");
            filter = input.value.toUpperCase();
            table = document.getElementById("table_lessons");
            tr = table.getElementsByTagName("tr");
            // selected_value = document.getElementById("select_filter").value;
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                for (j = 0; j < tr[i].getElementsByTagName("td").length; j++) {
                    td = tr[i].getElementsByTagName("td")[j];


                    // td = tr[i].getElementById("td-department")[0];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        // alert(txtValue);
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].getElementsByTagName("td")[j].style.display = "";
                        } else {
                            tr[i].getElementsByTagName("td")[j].style.display = "none";
                        }
                    }

                }
            }
        }
    </script>

    <!-- Tables start -->
    <div class="flex-row justify-content-start" style="width: 100%;">

        <!-- <a href="../lesson/lesson.php?addlesson" id="addlbtn" type="hidden" class="btn btn-outline-primary" style="margin-top: 2%; margin-bottom: 2%;">Add Lesson</a> -->

        <a href="../lesson/lesson.php?print" type="hidden" class="btn btn-outline-primary btn-sm" style="margin-top: 2%; margin-bottom: 2%;">Print view</a>

        <form class="col form-inline justify-content-end" style="margin-bottom: 2%;">
            <input id="search_lessons" onkeyup="myFunction()" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <!-- <select class="my-2 my-sm-0" id="select_filter">
                    <option selected>filter by</option>
                    <option value="name">name</option>
                    <option value="code">code</option>
                    <option value="lecturer">lecturer</option>
                    <option value="time">time</option>
                </select> -->
            <!-- <select class="my-2 my-sm-0" id="select_filter">
                    <option selected value="monday">monday</option>
                    <option value="tuesday">tuesday</option>
                    <option value="wednesday">wednesday</option>
                    <option value="thursday">thursday</option>
                    <option value="friday">friday</option>

                </select> -->
        </form>




    </div>

    <div id="hidden" class="">
        <table class="table table-sm table-bordered" id="table_lessons">
            <thead class="thead-dark">
                <th>Days</th>
            </thead>
            <tbody>



                <tr>
                    <!-- Monday -->
                    <th>Monday</th>
                    <?php
                    $lessons_result_monday = $db->query("select * from lesson where fragment='monday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                    if (!empty($lessons_result_monday)) {

                        while ($row = $lessons_result_monday->fetch_assoc()) {
                            // echo $row['lesson_name'];
                    ?>

                            <td class="" id="monday">


                                <? echo $row['lesson_name']; ?>
                                <br><br>

                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br>

                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>

                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <button class="btn btn-sm btn-outline-primary btn-delete" onclick="changeFunc(<?php echo $row['id']; ?>);" data-id="<?php echo $row['id']; ?>">Delete</button>


                                <br>
                                <br>
                            </td>

                    <?php }
                    } ?>


                </tr>

                <tr>
                    <th>Tuesday</th>
                    <?php

                    $lessons_result_tuesday = $db->query("select * from lesson where fragment='tuesday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                    if (!empty($lessons_result_tuesday)) {
                        while ($row = $lessons_result_tuesday->fetch_assoc()) {
                            // echo $row['lesson_name'];
                    ?>
                            <td class="h6" id="tuesday">

                                <? echo $row['lesson_name']; ?>
                                <br><br>
                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br>
                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>
                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Delete</a>
                                <!-- <hr> -->
                            </td>

                    <?php }
                    } ?>
                </tr>
                <tr>
                    <th>Wednesday</th>
                    <?php
                    $lessons_result_wednesday = $db->query("select * from lesson where fragment='wednesday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                    if (!empty($lessons_result_wednesday)) {

                        while ($row = $lessons_result_wednesday->fetch_assoc()) {
                            // echo $row['lesson_name'];
                    ?>
                            <td class="h6" id="wednesday">

                                <? echo $row['lesson_name']; ?>
                                <br><br>
                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br>
                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>
                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Delete</a>
                                <!-- <hr> -->
                            </td>

                    <?php }
                    } ?>
                </tr>
                <tr>
                    <th>Thursday</th>
                    <?php
                    $lessons_result_thursday = $db->query("select * from lesson where fragment='thursday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                    if (!empty($lessons_result_thursday)) {

                        while ($row = $lessons_result_thursday->fetch_assoc()) {
                            // echo $row['lesson_name'];
                    ?>
                            <td class="h6" id="thursday">

                                <? echo $row['lesson_name']; ?>
                                <br><br>
                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br>
                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>
                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="../process/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Delete</a>
                                <!-- <hr> -->

                            </td>

                    <?php }
                    } ?>
                </tr>
                <tr>
                    <th>Friday</th>
                    <?php
                    $lessons_result_friday = $db->query("select * from lesson where fragment='friday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                    if (!empty($lessons_result_friday)) {

                        while ($row = $lessons_result_friday->fetch_assoc()) {
                            // echo $row['lesson_name'];
                    ?>
                            <td class="h6" id="friday">
                                <? echo $row['lesson_name']; ?>
                                <br><br>
                                Time:
                                <?php echo date('h:i A', strtotime($row['from_time'])); ?> -
                                <?php echo date('h:i A', strtotime($row['to_time'])) ?>
                                <br>
                                Lecturer: <?php echo $row['lecturer']; ?>
                                <br><br>
                                <a href="../lesson/lesson.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>

                                <button class="btn btn-outline-primary btn-delete" data-id=" <?php echo $row['id']; ?>">Delete</button>
                                <!-- <hr> -->
                            </td>

                    <?php }
                    } ?>
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
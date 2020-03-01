<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="flex " style="width: 100%;">
        <a href="../exams/exams.php?printexam" type="hidden" class="btn btn-outline-primary btn-sm justify-content-start" style="margin-top: 2%; margin-bottom: 2%;">Print view</a>


        <form class="col form-inline justify-content-end" style="margin-bottom: 1%;">
            <input id="search_exam" onkeyup="myFunction()" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search timetables">
            <select class="custom-select my-2 my-sm-0" id="select_filter">
                <option selected>filter by</option>
                <option value="name">exam name</option>
                <option value="code">year</option>
                <option value="course">course</option>
                <option value="semester">semester</option>
                <option value="year">year</option>
                <option value="supervisor">supervisor</option>
                <option value="date">date</option>
                <option value="time">time</option>
                <option value="room">room</option>

            </select>
        </form>

    </div>


    <div class="">

        <table class="table table-sm table-bordered" id="table_exam">
            <thead class="thead-dark">
                <tr>
                    <th>NAME</th>
                    <th>CODE</th>
                    <th>COURSE</th>
                    <th>SEMESTER</th>
                    <th>SUPERVISOR</th>
                    <th>DATE</th>
                    <th>TIME</th>
                    <th>ROOM</th>
                    <th>ACTION</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $examquery = $db->query("select * from exam where department='$dept' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                if (!empty($examquery)) {


                    while ($row = $examquery->fetch_assoc()) {
                        // echo $row['lesson_name'];

                ?>
                        <tr>
                            <!-- NAME -->
                            <td class="h6"><?php echo $row['name']; ?>
                            </td>
                            <!-- CODE -->
                            <td class="h6"><?php echo $row['code']; ?>

                            </td>
                            <!-- COURSE -->
                            <td class="h6"><?php echo $row['course']; ?>

                            </td>

                            <!-- SEMESTER -->
                            <td class="h6"><?php echo $row['semester']; ?>

                            </td>
                            <!-- supervisor -->
                            <td class="h6"><?php echo $row['supervisor']; ?>

                            </td>
                            <!-- DATE -->
                            <td class="h6"><?php echo $row['exam_date']; ?>

                            </td>
                            <!-- TIME -->
                            <td class="h6"><?php echo $row['from_time']; ?> - <?php echo $row['to_time']; ?>

                            </td>
                            <!-- ROOM -->
                            <td class="h6"><?php echo $row['room']; ?>

                            </td>
                            <!-- ACTION -->
                            <td class="d-flex">
                                <a style="margin-right:5px;" href="../exams/exams.php?editexam=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Edit</a>
                                <button class="btn btn-outline-primary btn_delete_exam" data-id="<?php echo $row['id']; ?>">Delete</button>
                            </td>

                        </tr>
                <?php }
                } ?>

            </tbody>

        </table>

    </div>
    <script>
        document.querySelector('.btn_delete_exam').onclick = function() {
            var id = $(this).data('id');
            swal({
                    title: "Confirm to delete",
                    text: "Click ok to delete",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function() {
                    setTimeout(function() {
                        $.ajax({
                            method: "GET",
                            url: '../process/process.php',
                            data: 'deleteexam=' + id,
                            dataType: 'json',
                            beforeSend: () => {

                            },
                            success: function(data) {
                                swal("Ajax request finished!");

                            },
                            complete: () => {
                                window.location.href = "../exams/exams.php";
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.responseText);
                                alert(thrownError);
                            }
                        });
                        swal("Ajax request finished!");
                    }, 2000);
                });
        }
    </script>



    <script>
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue, selected_value;
            input = document.getElementById("search_exam");
            filter = input.value.toUpperCase();
            table = document.getElementById("table_exam");
            tr = table.getElementsByTagName("tr");
            selected_value = document.getElementById("select_filter").value;
            // alert(selected_value);
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                if (selected_value == 'name') {
                    td = tr[i].getElementsByTagName("td")[0];

                } else if (selected_value == 'code') {
                    td = tr[i].getElementsByTagName("td")[1];

                } else if (selected_value == 'course') {
                    td = tr[i].getElementsByTagName("td")[2];

                } else if (selected_value == 'semester') {
                    td = tr[i].getElementsByTagName("td")[3];

                } else if (selected_value == 'supervisor') {
                    td = tr[i].getElementsByTagName("td")[4];

                } else if (selected_value == 'date') {
                    td = tr[i].getElementsByTagName("td")[5];

                } else if (selected_value == 'time') {
                    td = tr[i].getElementsByTagName("td")[6];

                } else if (selected_value == 'room') {
                    td = tr[i].getElementsByTagName("td")[7];

                } else {
                    td = tr[i].getElementsByTagName("td")[0];

                }
                // td = tr[i].getElementById("td-department")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    // alert(txtValue);
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>

</html>
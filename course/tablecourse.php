<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>

<body>
    <div class="flex-row justify-content-start" style="width: 100%;">

        <!-- <a href="../lesson/lesson.php?addlesson" id="addlbtn" type="hidden" class="btn btn-outline-primary" style="margin-top: 2%; margin-bottom: 2%;">Add Lesson</a> -->
        <!-- <td id="categoryTd" colspan="5"> -->

        <!-- </td> -->

        <!-- <a href="../course/course.php?print" type="hidden" class="btn btn-outline-primary btn-sm" style="margin-top: 2%; margin-bottom: 2%;">Print view</a> -->
        <form class="col form-inline justify-content-end" style="margin-bottom: 1%;">
            <input id="search_course" onkeyup="myFunction()" class="form-control mr-sm-2" type="search"
                placeholder="Search course" aria-label="Search">
        </form>


    </div>

    <div id="hidden" class="">


        <table class="table table-sm " id="course_table">
            <thead>
                <tr>
                    <th onclick="sortTable(0,'course_table')"><a href="#">COURSE</a></th>
                    <th onclick="sortTable(1,'course_table')"><a href="#">STUDY YEARS</a></th>
                    <th onclick="sortTable(2,'course_table')">ACTION</th>

                </tr>
            </thead>
            <tbody>

                <?php
                $dept = $_SESSION['ldep_name'];
                $datalist_lesson = $db->query("select * from courses where department='$dept';");
                if (!empty($datalist_lesson)) {
                    $i = 0;
                    while ($row = $datalist_lesson->fetch_assoc()) {
                        $i++;
                ?>

                <tr id="row_course">
                    <!-- course -->

                    <td class="h6">
                        <a href="../course/course.php?edit_course=<?php echo $row['id']; ?>">
                            <?php echo $row['course_name'] ?></a>
                    </td>

                    <td class="h6">
                        <?php echo $row['years_of_study'] ?>

                    </td>

                    <!-- action -->
                    <td class="h6">
                        <!-- <a href="../course/course.php?edit_course=
                                <?php
                                //  echo $row['id']; 
                                ?>
                                " class="btn btn-sm btn-outline-primary">Edit</a> -->
                        <button class="btn btn-sm btn-outline-primary btn_delete_course"
                            onclick="deletecourse( <?php echo $row['id']; ?>)"
                            data-id=" <?php echo $row['id']; ?>">Delete</button>

                        <?php $stripped = preg_replace('/\s+/', ' ', $row['course_name']);
                                $classname = str_replace(' ', '', $stripped);
                                ?>
                        <button class="btn btn-sm btn-outline-primary collapsed" type="button" data-toggle="collapse"
                            <?php echo "data-target='#" . $classname . "'" ?> aria-expanded="false"
                            aria-controls="<?php echo $classname; ?>">View Units
                        </button>

                        <a href="../process/process.php?addunit=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-outline-primary">Add Unit</a>
                    </td>

                </tr>
                <thead>
                    <tr <?php echo "id=" . $classname; ?> class="collapse">
                        <th>Unit name</th>
                        <th>Unit Code</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>Reg Stud</th>
                    </tr>
                </thead> <?php
                                    $courseid = $row['id'];
                                    $datalist_course = $db->query("select * from units where course='$courseid';") or die($db->error);
                                    if (!empty($datalist_course)) {
                                        $i = 0;
                                        while ($rowunit = $datalist_course->fetch_assoc()) {
                                            $i++;

                                    ?>
                <tr <?php echo "id=" . $classname; ?> class="collapse">

                    <th><?php echo $rowunit['name']; ?></th>
                    <th class=""><?php echo $rowunit['code']; ?></th>
                    <th class=""><?php echo $rowunit['year']; ?></th>
                    <th class=""><?php echo $rowunit['semester']; ?></th>
                    <th class=""><?php echo $rowunit['stud_no']; ?></th>
                    <th class=""> <a href="course.php?edit_unit=<?php echo $rowunit['id'] ?>"
                            class="btn btn-sm btn-outline-primary">Edit Unit</a>
                    </th>
                </tr>
                <?php }
                                    } ?>
                <?php  }
                } ?>
            </tbody>

        </table>


    </div>
    <script>
    function deletecourse(id) {
        swal({
                title: "Delete course",
                text: "This action will result to all units in that course deleted",
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
                        data: 'delete_course=' + id,
                        dataType: 'json',
                        beforeSend: () => {

                        },
                        success: function(data) {
                            swal("Ajax request finished!");

                        },
                        complete: () => {
                            window.location.href = "../course/course.php";
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            // alert(xhr.responseText);
                            // alert(thrownError);
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
        var input, filter, table, tr, td, i, txtValue, selected_value, th;
        input = document.getElementById("search_course");
        filter = input.value.toUpperCase();
        table = document.getElementById("course_table");
        tr = table.getElementsByTagName("tr");
        // document.getElementById("row_course");

        // table.getElementsByTagName("tr");
        // alert(selected_value);
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {

            td = tr[i].getElementsByTagName("td")[0];
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
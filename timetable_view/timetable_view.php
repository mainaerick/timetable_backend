<!DOCTYPE html>
<html lang="en">
<?php
include '../process/process.php';
include '../logout/checklogin.php';
check_login();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Timetables</title>

    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css">


    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script> -->
</head>

<body>
    <?php
    include "../includes/nav.php";
    ?>

    <?php
    // if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) {

    // }
    // else{
    include "../includes/sidebar_admin.php";

    // }
    ?>

    <div class="container" style="margin-top: 3%;">

        <nav class="navbar navbar-light bg-light">
            <form class="form-inline">
                <input id="search_timetable" onkeyup="myFunction()" class="form-control mr-sm-2" type="search" placeholder="Search timetables" aria-label="Search timetables">
                <select class="custom-select my-2 my-sm-0" id="select_filter">
                    <option selected>filter by</option>
                    <option value="course">course</option>
                    <option value="year">year</option>
                    <option value="semester">semester</option>
                </select>
            </form>
        </nav>

        <table class="table table-sm table-bordered" id="timetable_table">
            <thead class="thead-dark">
                <tr>
                    <th>Course</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Semester</th>

                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                <?php
                // $dept = $_SESSION['ldep'];
                $datalist_lesson = $db->query("SELECT * FROM timetables ORDER BY course") or die($db->error);
                if (!empty($datalist_lesson)) {
                    $i = 0;
                    while ($row = $datalist_lesson->fetch_assoc()) {
                        $i++;
                ?>


                        <tr>

                            <!-- course -->
                            <td class="h6">
                                <?php echo $row['course'] ?>
                            </td>

                            <!-- department -->
                            <td class="h6">
                                <?php echo $row['department'] ?>
                            </td>

                            <td class="h6">
                                <?php echo $row['year'] ?>
                            </td>
                            <td class="h6">
                                <?php echo $row['semester'] ?>
                            </td>
                            <!-- action -->
                            <td class="h6">

                                <a href="../timetable_view/timetable_view.php?view_timetable_lesson=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">View class</a>

                                <a href="../timetable_view/timetable_view.php?view_timetable_exam=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">View exam</a>

                            </td>

                        </tr>
                <?php  }
                } ?>

            </tbody>

        </table>



        <!-- table view -->
        <div>
            <? if (isset($_GET['view_timetable_lesson'])) {
                echo $ltablecourse;
                echo " | " . $lyear;
                echo " | " . $lsemester;

                include '../lesson/table_lesson.php';
            } elseif (isset($_GET['view_timetable_exam'])) {
                echo $ltablecourse;
                echo " | " . $lyear;
                echo " | " . $lsemester;
                include '../exams/exam_table.php';
            } ?>
        </div>




    </div>


    <script>
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue, selected_value;
            input = document.getElementById("search_timetable");
            filter = input.value.toUpperCase();
            table = document.getElementById("timetable_table");
            tr = table.getElementsByTagName("tr");
            selected_value = document.getElementById("select_filter").value;
            // alert(selected_value);
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                if (selected_value == 'department') {
                    td = tr[i].getElementsByTagName("td")[1];

                } else if (selected_value == 'course') {
                    td = tr[i].getElementsByTagName("td")[0];

                } else if (selected_value == 'year') {
                    td = tr[i].getElementsByTagName("td")[2];

                } else if (selected_value == 'semester') {
                    td = tr[i].getElementsByTagName("td")[3];

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
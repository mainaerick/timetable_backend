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

        <table class="table table-sm table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
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
                            <!-- number -->
                            <td class="h6">
                                <?php echo $i; ?>

                            </td>

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



</body>

</html>
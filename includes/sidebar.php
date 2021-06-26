<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <!-- Sidebar -->
    <?php
    // include "../includes/nav.php";
    ?>
    <div class="bg-dark border-right position-fixed" id="sidebar-wrapper">
        <div class="list-group list-group-flush">
            <a style="padding-bottom: 18%; padding-top: 18%; color: #fff;" href="../lesson/lesson.php" class="list-group-item list-group-item-action bg-dark">Class TimeTable</a>
            <!-- <a href="#homeSubmenu" class="list-group-item list-group-item-action bg-light" data-toggle="collapse"
                aria-expanded="false" class="dropdown-toggle">Home</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li class="list-group-item">
                    <a href="../process/process.php?course"></a>
                </li>
                <li class="list-group-item">
                    <a href="../process/process.php?course"></a>
                </li>
                <li class="list-group-item">
                    <a href="../process/process.php?course"></a>
                </li>
                <li class="list-group-item">
                    <a href="../process/process.php?course"></a>
                </li>


            </ul> -->
            <a href="../exams/exams.php" style="padding-bottom: 18%; padding-top: 18%; color: #fff;" class="list-group-item list-group-item-action bg-dark">Exam Timetables</a>
            <a href="../course/course.php" style="padding-bottom: 18%; padding-top: 18%; color: #fff;" class="list-group-item list-group-item-action bg-dark">Courses</a>
            <a href="../lecturers/lecturer.php" style="padding-bottom: 18%; padding-top: 18%; color: #fff;" class="list-group-item list-group-item-action bg-dark">Lecturer</a>

            <!-- <a href="../feedback/feedback.php" style="padding-bottom: 18%; padding-top: 18%;color: #fff;" class="list-group-item list-group-item-action bg-dark">Feedbacks</a> -->


        </div>
    </div>
    <!-- /#sidebar-wrapper -->
</body>

</html>
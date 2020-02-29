<!DOCTYPE html>
<html lang="en">
<?php
include '../process/process.php';
include '../logout/checklogin.php';
check_login();
$_SESSION['page'] = '../lesson/lesson.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>




    <table class="table table-sm table-bordered" id="table_lessons">
        <thead class="thead-dark">
            <tr>
                <!-- <th>TIME</th>
                <th>TUESDAY</th>
                <th>WEDNESDAY</th>
                <th>THURSDAY</th>
                <th>FRIDAY</th> -->


            </tr>
        </thead>
        <tbody>
            <tr>
                <td>monday</td>
                <?php
                $lessons_result_monday = $db->query("select * from lesson where fragment='monday' and department='$dept_name' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                if (!empty($lessons_result_monday)) {

                    while ($row = $lessons_result_monday->fetch_assoc()) {
                        // echo $row['lesson_name'];
                ?>
                        <td>
                            <?
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
                        </td>
                <?php }
                } ?>

            </tr>
            <tr>
                <td>tuesday</td>
                <td>loop tuesday</td>
            </tr>
            <tr>
                <td>wednesday</td>
                <td>loop wednesday</td>
            </tr>
            <tr>
                <td>thursay</td>
                <td>loop thursday</td>
            </tr>
            <tr>
                <td>friday</td>
                <td>loop friday</td>
            </tr>


        </tbody>

    </table>
    <!-- Monday -->
    <td class="text-lg" id="monday">
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
    <!-- Tuesday -->
    <td class="h6" id="tuesday">
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
    <td class="h6" id="wednesday">
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

    <td class="h6" id="thursday">
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
    <td class="h6" id="friday">
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

</body>

</html>
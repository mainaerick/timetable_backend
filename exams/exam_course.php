<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>

<body>
    <h6>Units Available</h6>
    <table id="table_examc" class="w-100 table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Unit name</th>
                <th scope="col">Code</th>
                <th scope="col">Lecturer</th>

            </tr>
        </thead>
        <tbody>
            <?php if (empty($_SESSION['semester']) || empty($_SESSION['lcourse']) || empty($_SESSION['year'])) { } else {
                $dept = $_SESSION['ldep_name'];
                $ltablecourse = $_SESSION['lcourse'];
                $lyear = $_SESSION['year'];
                $lsemester = $_SESSION['semester'];
                $datalist_lesson = $db->query("select * from lesson where department='$dept' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';");
                if (!empty($datalist_lesson)) {
                    while ($row = $datalist_lesson->fetch_assoc()) {
                        ?>


            <tr>
                <td class="name_unit"><?php echo $row['lesson_name'];?></td>
                <td class="code_unit"><?php echo $row['code'];?></td>
                <td class="lec_unit"><?php echo $row['lecturer'];?></td>
            </tr>
            <?php
                    }
                }
            } ?>
        </tbody>
    </table>
    

</body>

</html>
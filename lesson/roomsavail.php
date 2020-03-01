<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>

<body>
    <h6>Available Rooms</h6>
    <table id="table_lessonl" class="w-100 table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Room name</th>
                <th scope="col">Room capacity</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($_SESSION['semester']) || empty($_SESSION['lcourse']) || empty($_SESSION['year'])) {
            } else {
                $dept = $_SESSION['ldep_name'];
                $ltablecourse = $_SESSION['lcourse'];
                $lyear = $_SESSION['year'];
                $lsemester = $_SESSION['semester'];
                $datalist_lesson = $db->query("select * from room;");
                if (!empty($datalist_lesson)) {
                    while ($row = $datalist_lesson->fetch_assoc()) {
            ?>


                        <tr class="tr_lecavailable">
                            <td class="lec_name"><?php echo $row['name']; ?></td>
                        </tr>
            <?php
                    }
                }
            } ?>
        </tbody>
    </table>


</body>

</html>
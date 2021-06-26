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
                <th scope="col">Lec email</th>
                <th scope="col">Student No.</th>


            </tr>
        </thead>
        <tbody>
            <?php if (empty($_SESSION['semester']) || empty($_SESSION['lcourse']) || empty($_SESSION['year'])) {
            } else {
                $dept = $_SESSION['ldep_name'];
                $ltablecourse = $_SESSION['lcourse'];
                $lyear = $_SESSION['year'];
                $lsemester = $_SESSION['semester'];
                //                 "SELECT FirstName, LastName, MobileNo, COUNT(*) as CNT
                // FROM  CUSTOMER
                // GROUP BY FirstName, LastName, MobileNo;
                // HAVING COUNT(*)  = 1";

                // $datalist_lesson = $db->query("SELECT lesson_name , code , lecturer , ROW_NUMBER() OVER (PARTITION BY lesson_name , code , lecturer ORDER BY lesson_name) AS Cnt
                // FROM lesson)
                // SELECT lesson_name , code , lecturer FROM CTE WHERE Cnt = 1") or die($db->error);

                // check if lesson exist in exam table during exam period
                

                $datalist_lesson = $db->query("select distinct lesson_name, code, lecturer from lesson where department='$dept' and course='$ltablecourse' and year_of_study='$lyear' and semester='$lsemester';") or die($db->error);
                if (!empty($datalist_lesson)) {
                    while ($row = $datalist_lesson->fetch_assoc()) {
                        $code=$row['code'];


                        $check_unit = $db->query("select * from exam where code = '$code' and semester= '$lsemester' and year_of_study='$lyear';") or die($db->error);

                        if($check_unit->num_rows){}else{


                        

            ?>


                        <tr class="tr_lavailable">
                            <td class="name_unit"><?php echo $row['lesson_name']; ?></td>
                            <td class="code_unit"><?php echo $row['code']; ?></td>
                            <td class="lec_unit"><?php echo getlecbyid($db, $row['lecturer']); ?></td>
                            <td class="lec_reg"><?php echo getlec_regbyid($db, $row['lecturer']); ?></td>
                            <td class="std_no"><?php echo getunit_bycode($db, $row['code']); ?></td>

                        </tr>
            <?php
                    }
                }
                }
            } ?>
        </tbody>
    </table>


</body>

</html>
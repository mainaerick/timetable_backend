<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="flex-row justify-content-start" style="width: 100%;">



        <a href="../exams/exams.php?printexam" type="hidden" class="btn btn-outline-primary btn-sm"
            style="margin-top: 2%; margin-bottom: 2%;">Print view</a>
    </div>


    <div class="">

        <table class="table table-sm table-bordered">
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
                    <td class="h6"><?php echo $row['date']; ?>

                    </td>
                    <!-- TIME -->
                    <td class="h6"><?php echo $row['from_time']; ?> - <?php echo $row['to_time']; ?>

                    </td>
                    <!-- ROOM -->
                    <td class="h6"><?php echo $row['room']; ?>

                    </td>
                    <!-- ACTION -->
                    <td class="d-flex">
                        <a style="margin-right:5px;" href="../exams/exams.php?editexam=<?php echo $row['id']; ?>"
                            class="btn btn-outline-primary">Edit</a>
                        <button
                            class="btn btn-outline-primary btn_delete_exam" data-id="<?php echo $row['id']; ?>">Delete</button>
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
</body>

</html>
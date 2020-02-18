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


        <a href="../course/course.php?print" type="hidden" class="btn btn-outline-primary btn-sm"
            style="margin-top: 2%; margin-bottom: 2%;">Print view</a>



    </div>

    <div id="hidden" class="">


        <table class="table table-sm table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>COURSE</th>
                    <th>STUDY YEARS</th>
                    <th>ACTION</th>

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



                <tr>
                    <!-- number -->
                    <td class="h6">
                        <?php echo $i; ?>

                    </td>

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
                        <button class="btn btn-outline-primary btn_delete_course"
                            data-id=" <?php echo $row['id']; ?>">Delete</button>
                    </td>

                </tr>
                <?php  }
                } ?>

            </tbody>

        </table>


    </div>
    <script>
    document.querySelector('.btn_delete_course').onclick = function() {
        var id = $(this).data('id');
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
</body>

</html>
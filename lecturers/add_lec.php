<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>

<body>
    <div style="margin-bottom: 3px;">

    </div>
    <form id="form_lesson" class="w-100 p-7 border needs-validation"
        style="padding: 5%; margin-bottom: 5%; margin-top: 2%;" action="../process/process.php" method="POST">

        <div style="margin-bottom: 3px;" class="row justify-content-end">
            <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->
            <a class="btn btn-outline-secondary btn-sm" href="../lecturers/lecturer.php?hidelectureradd" role="group"
                aria-label="Third group">Close</a>

        </div>

        <input type="hidden" value="<?php echo $id ?>" name="lecturer_id">
        <div class="form-group row">
            <label class="col-sm-4" for="coursename">Lecturer Name</label>
            <input type="text" class="col-sm-8 form-control form-control-sm" id="lec_name" name="lec_name"
                value="<?php echo $editlecname; ?>" placeholder="name of the lecturer" required>

        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="course_years">Email</label>
            <input type="email" class="col-sm-8 form-control form-control-sm" id="lec_email" name="lec_email"
                value="<?php echo $editlecemail; ?>" placeholder="Email address of the lecturer"
                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
        </div>
        <div class="valid-feedback feedback-pos">
            Looks good!
        </div>
        <div class="invalid-feedback feedback-pos">
            Please input valid email ID
        </div>
        <div class="row justify-content-center">

            <div class="form-group">
                <?php if ($update == false) { ?>
                <input class="btn btn-outline-success" type="submit"  name="save_lecturer"
                    value="Add">
                    <!-- onclick="deletecourse(1)" -->
                <?php } else { ?>
                <input class="btn btn-outline-success" type="submit" name="update_lecturer" value="Update">
                <?php }
                ?>
            </div>


        </div>
        <?php
        if (isset($_SESSION['lecturer_exist'])) {

        ?>

        <span class="row form-group justify-content-center alert alert-warning" role="alert">

            <?php
            echo $_SESSION['lecturer_exist'];
            unset($_SESSION['lecturer_exist']);
        }

            ?>

        </span>

    </form>


    <script>
    function deletecourse(id) {
        swal({
                title: "Adding Lecturer...",
                text: "This action will send an email to the lecturer containing password",
                type: "info",
                showCancelButton: false,
                closeOnConfirm: false,
                showLoaderOnConfirm: false
            },
            function() {
                setTimeout(function() {
                    $.ajax({
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
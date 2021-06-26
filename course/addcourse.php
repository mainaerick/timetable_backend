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
    <form id="form_lesson" class="w-100 p-7 border" style="padding: 5%; margin-bottom: 5%; margin-top: 2%;" action="../process/process.php" method="POST">


    

        <div style="margin-bottom: 3px;" class="row justify-content-end">
            <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->
            <a class="btn btn-outline-secondary btn-sm" href="../course/course.php?hidecourseadd" role="group" aria-label="Third group" style="">Close</a>

        </div>

        <input type="hidden" value="<?php echo $id ?>" name="course_id">
        <div class="form-group row">
            <label class="col-sm-4" for="coursename">Course Name</label>
            <input type="text" style="text-transform: uppercase" class="col-sm-8 form-control form-control-sm" id="coursename" name="course_name" value="<?php echo $editcoursename; ?>" placeholder="name of the course" required>

        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="course_years">Course Years</label>
            <select class="col-sm-8 form-control form-control-sm" name="course_years" value="" id="course_years">
                <option selected>
                    <?php if (isset($_GET['edit_course'])) {
                        echo $editcourseyears;
                    } ?>
                </option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
            </select>

        </div>

        <div class="row justify-content-center">

            <div class="form-group">
                <?php if ($update == false) { ?>
                    <input class="btn btn-outline-success" type="submit" name="save_course" value="Add">
                <?php } else { ?>
                    <input class="btn btn-outline-success" type="submit" name="update_course" value="Update">
                <?php }
                ?>

            </div>


        </div>
        <?php
        if (isset($_SESSION['course_exist'])) {

        ?>

            <span class="row form-group justify-content-center alert alert-warning" role="alert">

            <?php
            echo $_SESSION['course_exist'];
            unset($_SESSION['course_exist']);
        }

            ?>

            </span>

    </form>



</body>

</html>
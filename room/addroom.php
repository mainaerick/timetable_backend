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
            <a class="btn btn-outline-secondary btn-sm" href="../course/course.php?hideroomadd" role="group" aria-label="Third group">Close</a>

        </div>

        <input type="hidden" value="<?php echo $id ?>" name="room_id">
        <div class="form-group row">
            <label class="col-sm-4" for="coursename">Room Name</label>
            <input type="text" class="col-sm-8 form-control form-control-sm" id="room_name" name="room_name" value="<?php echo $editroomname; ?>" placeholder="name of the room" required>

        </div>
        <div class="form-group row">
            <label class="col-sm-4" for="course_years">Capacity</label>
            <input type="text" class="col-sm-8 form-control form-control-sm" id="room_capacity" name="room_capacity" value="<?php echo $editroomcapacity; ?>" placeholder="number of students to occupy" required>

        </div>
        <div class="row justify-content-center">

            <div class="form-group">
                <?php if ($update == false) { ?>
                    <input class="btn btn-outline-success" type="submit" name="save_room" value="Add">
                <?php } else { ?>
                    <input class="btn btn-outline-success" type="submit" name="update_room" value="Update">
                <?php }
                ?>
            </div>


        </div>
        <?php
        if (isset($_SESSION['room_exist'])) {

        ?>

            <span class="row form-group justify-content-center alert alert-warning" role="alert">

            <?php
            echo $_SESSION['room_exist'];
            unset($_SESSION['room_exist']);
        }

            ?>

            </span>

    </form>



</body>

</html>
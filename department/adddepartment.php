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
    <form id="form_dep" class="w-100 p-7 border" style="padding: 5%; margin-bottom: 5%; margin-top: 2%;"
        action="../process/process.php" method="POST">





        <div style="margin-bottom: 3px;" class="row justify-content-end">
            <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->
            <a class="btn btn-outline-secondary btn-sm" href="../department/department.php?hidedepartmentadd" role="group"
                aria-label="Third group" style="">Close</a>

        </div>

        <input type="hidden" value="<?php echo $name ?>" name="department_name">
        <div class="form-group row">
            <label class="col-sm-4" for="coursename">Department Name</label>
            <input type="text" class="col-sm-8 form-control form-control-sm" id="depname" name="department_name"
                value="<?php echo $editdep_name; ?>" placeholder="name of the department" required>

        </div>
        

        <div class="row justify-content-center">

            <div class="form-group">
                <?php if ($update == false) { ?>
                <input class="btn btn-outline-success" type="submit" name="save_dep" value="Add">
                <?php } else { ?>
                <input class="btn btn-outline-success" type="submit" name="save_dep" value="Update">
                <?php }
                ?>

            </div>


        </div>
        <?php
                    if (isset($_SESSION['dep_exist'])) {

                        ?>

                        <span class="row form-group justify-content-center alert alert-warning" role="alert">

                            <?php
                            echo $_SESSION['dep_exist'];
                            unset($_SESSION['dep_exist']);
                        }

                        ?>

                        </span>

    </form>


    
</body>

</html>
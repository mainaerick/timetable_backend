<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <div style="margin-bottom: 3px;">

    </div>
    <form id="form_lesson" class="w-100 p-7 border" style="padding: 5%; margin-bottom: 5%; margin-top: 2%;" action="../process/process.php" method="POST">
        <div style="margin-bottom: 3px;" class="row justify-content-end">
            <!-- <button id="close_lesson" class="btn btn-outline-secondary btn-sm">Close</button> -->

        </div>

        <input type="hidden" value="<?php echo $id ?>" name="id">
        <div class="form-group row">
            <label class="col-sm-4" for="subject">Lesson Name</label>
          

        </div>
        


    </form>

    <!-- input end -->


</body>

</html>
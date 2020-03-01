<!DOCTYPE html>
<html lang="en">
<?php 
include 'process/connect.php';
include 'process/process.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css">


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body>
<? include "includes/nav.php";
 ?>
    <div class="container">
        <div>
            <div class="row justify-content-center">

                <form class="border border-dark w-30 p-7 border" style="padding: 5%; margin-top: 10%;"
                    action="process/process.php" method="POST">

                    <!-- <div class="form-group row"> -->
                    <!-- <label for="subject">Department</label> -->
                    <!-- <select class="form-control" name="ldepartment" id="exampleFormControlSelect1"> -->
                    <?php 
                            // $query_department = $db->query("select * from department order by name asc");
                            // while ($row = $query_department->fetch_assoc()) { ?>
                    <!-- <option class="form-control"><?php echo $row['name']; ?></option> -->
                    <?php
                            //  } 
                            ?>

                    <!-- </select> -->
                    <!-- </div> -->

                    <a class="form-group row justify-content-end" href="signup/sinup.php">signup</a>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                            required>
                    </div>


                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="logpass" name="password" placeholder="Password"
                            required>
                    </div>
                    <div class="form-group row justify-content-center">
                        <input class="btn btn-outline-primary" type="submit" name="login" value="Login">
                    </div>

                    <?php

                    if (isset($_SESSION['login_err'])) {

                        ?>

                    <div class="form-group alert alert-warning" <?= $_SESSION['login_err'] ?>>
                        <?php
                            echo $_SESSION['login_err'];
                            unset($_SESSION['login_err']);
                        }

                        ?>

                    </div>
                </form>

            </div>
        </div>
    </div>

</body>




</html>
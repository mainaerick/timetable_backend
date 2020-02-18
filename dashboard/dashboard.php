<!DOCTYPE html>
<html>
<?php

$_SESSION['page'] = './dashboard.php';

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <!-- 
  <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css">


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</head>

<body>

    <?php
    include "../includes/nav.php";
    ?>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <?php include "../includes/sidebar_admin.php" ?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="padding: 0%; margin-left: 10%; margin-top: 0%;">

            <div class="page-content-wrapper container" style="padding: 0%;  margin-top: 3%;">
                <h3>DASHBOARD/Admin</h3>
                <hr>


                

                <div class="row justify-content-center">

                <div class="col-sm-4 mt-4">
                    <div class="card">

                        <div class="card-block">
                            <h4 class="card-title mt-3">TimeTables</h4>
                            <div class="meta">
                                <a>3</a>
                            </div>
                            <div class="card-text">
                                click to view all timetables
                            </div>
                        </div>
                        <div class="card-footer">
                            <small>
                            <?  $result = $db->query("select * from timetables"); echo $result->num_rows ?>
                             Timetables available</small>
                            <button class="btn btn-secondary float-right btn-sm">Manage</button>
                        </div>
                    </div>
                </div>
                    <div class="col-sm-4 mt-4">
                    <div class="card">

                        <div class="card-block">
                            <h4 class="card-title mt-3">Departments</h4>
                            <div class="meta">
                                <a>3</a>
                            </div>
                            <div class="card-text">
                                click show for more details
                            </div>
                        </div>
                        <div class="card-footer">
                            <small>
                                <?  $result = $db->query("select * from department"); echo $result->num_rows ?> Department available</small>
                            <!-- <a class="btn btn-secondary float-right btn-sm">manage</button> -->
                            <a class="btn btn-secondary float-right btn-sm" href="../department/department.php">manage</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 mt-4">
                    <div class="card">

                        <div class="card-block">
                            <h4 class="card-title mt-3">Users</h4>
                            <div class="meta">
                                <!-- SUB TITLE -->
                                <a style="color:crimson;">
                                <? $result = $db->query("select * from users where status= 'not approved'"); echo $result->num_rows ?> Request</a>
                            </div>
                            <div class="card-text">
                                click show for more details
                            </div>
                        </div>

                        <!-- request SHOWING -->
                        <div class="card-footer">
                            <small>
                            <? $result = $db->query("select * from users where status= 'approved'"); echo $result->num_rows ?> Users available
                                </small>
                            <!-- <a class="btn btn-secondary float-right btn-sm">manage</button> -->
                            <a href="../users/users.php" class="btn btn-secondary float-right btn-sm">manage</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col d-flex flex-row justify-content-end">


                <hr>

                <!-- inputs start -->
                <div class="row">


                </div>

            </div>

        </div>
        <!-- /#page-content-wrapper -->
</body>


</html>
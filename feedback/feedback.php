<!DOCTYPE html>
<html>
<?php
include '../process/process.php';
include '../logout/checklogin.php';

check_login();
$_SESSION['page'] = '../feedback/feedback.php';

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <?php include "../includes/sidebar.php" ?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="padding: 0%; margin-left: 10%; margin-top: 0%;">

            <div class="">
                <div class="page-content-wrapper container" style="padding: 0%;  margin-top: 3%;">
                    <h3>FEEDBACKS</h3>
                    <hr>

                    <div class="col">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Sender Reg. No.</th>
                                    <th scope="col">Sent date</th>
                                    <th scope="col">Resolved date</th>
                                    <th scope="col">Option</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
              $feedback_query = $db->query("select * from feedback;");
              if (!empty($feedback_query)) {

                $i=1;
                while ($row = $feedback_query->fetch_assoc()) {
                    $i++;
                  // echo $row['lesson_name'];

                  ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $row['content']; ?></td>
                                    <td><?php echo $row['user_reg_no']; ?></td>
                                    <td><?php echo $row['received_date']; ?></td>
                                    <td><?php echo $row['reply_date']; ?></td>
                                    
                                    <td>
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Lesson TimeTable</a>
                                            <a class="dropdown-item" href="#">Exams TimeTable</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Delete</a>
                                        </div>
                                    </td>


                                </tr>
                <?php }} ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="col d-flex flex-row justify-content-end">


                        <hr>

                        <!-- inputs start -->
                        <div class="row">


                        </div>

                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
</body>


</html>
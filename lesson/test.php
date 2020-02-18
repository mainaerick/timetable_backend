
<!DOCTYPE html>
<html>
<?php
include '../process/process.php';
include '../logout/checklogin.php';
// check_login();
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lessons</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

  <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css">


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>

<nav class="fixed-top navbar navbar-expand-lg navbar-dark bg-dark">
<button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link active" href="lesson.php">Lessons<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../exams/exams.php">Exams</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../users/users.php">Users</a>
        </li>
      </ul>
      <span class="navbar-text">
        <a href="../logout/logout.php">Log out</a>
      </span>



    </div>
  </nav>
<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Start Bootstrap </div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      

      <div class="container-fluid">
      <div class="container page-content-wrapper">
      <div class="row justify-content-center">
        <form class="w-50 p-7 border" style="padding: 5%; margin-bottom: 5%; margin-top: 10%;" action="../process/process.php" method="POST">


        <input type="hidden" value="<?php echo $id ?>" name="id" >
          <div class="form-group row">
            <label for="subject">Lesson</label>
            <input type="text" class="form-control" id="subject" name="lesson" value="<?php echo $editlessonname; ?>" placeholder="name of the lesson" required>

          </div>
          <div class="form-group row">
            <label for="dayselect">Select Day</label>
            <select class="form-control" name="fragment" value="<?php echo $editfragment; ?>" id="exampleFormControlSelect1">
            <option selected><?php echo $editfragment; ?></option>
              <option>Monday</option>
              <option>Tuesday</option>
              <option>Wednesday</option>
              <option>Thursday</option>
              <option>Friday</option>
            </select>
          </div>

          <div class="form-group row">
            <label for="lecturer">Lecturer</label>
            <input type="text" class="form-control" id="lecturer" name="lecturer" value="<?php echo $editlecturer; ?>" placeholder="name of the lecturer" required>
          </div>

          <div class="form-group row">
            <label for="room">Room</label>
            <input type="text" class="form-control" id="room" name="room" value="<?php echo $editroom; ?>" placeholder="place the lesson to be held at" required>
          </div>

          <div class="form-group row">

            <label for="fromtime">From</label>
            <input type="time" class="form-control" name="fromtime" value="<?php echo $editfromtime; ?>" placeholder="From Time" id="fromtime" required>
          </div>


          <div class="form-group row">
            <label for="totime">To</label>
            <input type="time" class="form-control" name="totime" value="<?php echo $edittotime; ?>" placeholder="To Time" id="totime" required>
          </div>


          <div class="form-group row">
          <?php if ($update==false){?>
            <input class="btn btn-outline-primary" type="submit" name="save_lesson" value="Add">
          <?php }
          else { ?>
            <input class="btn btn-outline-primary" type="submit" name="update" value="Update">
          <?php }
          ?>
            
          </div>
        </form>
      </div>

      <!-- input end -->

      <div class="border d-flex flex-row bd-highlight mb-6">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th >Monday</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $lessons_result_monday=$db->query("select * from lesson where fragment='monday';");
              while($row=$lessons_result_monday->fetch_assoc()){
              // echo $row['lesson_name'];
              
              ?>
            <tr>
            <td class="h6"><?php echo $row['lesson_name'];?>
                <br><br>
                Time:<?php echo $row['from_time'];?>-<?php echo $row['to_time'];?>
                <br><br>
                Lecturer: <?php echo $row['lecturer'];?>
                <br><br>
                <a href="../lesson/lesson.php?edit=<?php echo $row['id'];?>" class="btn btn-outline-primary">Edit</a>
                <a href="../process/process.php?delete=<?php echo $row['id'];?>" class="btn btn-outline-primary">Delete</a>
              </td>
              <?php  }?>
            </tr>


          </tbody>

        </table>



        <table class="table table-bordered">
          <thead>
            <tr>
              <th >Tuesday</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $lessons_result_tuesday=$db->query("select * from lesson where fragment='tuesday';");
              while($row=$lessons_result_tuesday->fetch_assoc()){
              // echo $row['lesson_name'];
              
              ?>
            <tr>
            <td class="h6"><?php echo $row['lesson_name'];?>
                <br><br>
                Time:<?php echo $row['from_time'];?>-<?php echo $row['to_time'];?>
                <br><br>
                Lecturer: <?php echo $row['lecturer'];?>
                <br><br>
                <a href="../lesson/lesson.php?edit=<?php echo $row['id'];?>" class="btn btn-outline-primary">Edit</a>
                <a href="../process/process.php?delete=<?php echo $row['id'];?>" class="btn btn-outline-primary">Delete</a>
              </td>
              <?php  }?>
            </tr>


          </tbody>

        </table>



        <table class="table table-bordered">
          <thead>
            <tr>
              <th >Wednesday</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $lessons_result_wednesday=$db->query("select * from lesson where fragment='wednesday';");
              while($row=$lessons_result_wednesday->fetch_assoc()){
              // echo $row['lesson_name'];
              
              ?>
            <tr>
            <td class="h6"><?php echo $row['lesson_name'];?>
                <br><br>
                Time:<?php echo $row['from_time'];?>-<?php echo $row['to_time'];?>
                <br><br>
                Lecturer: <?php echo $row['lecturer'];?>
                <br><br>
                <a href="../lesson/lesson.php?edit=<?php echo $row['id'];?>" class="btn btn-outline-primary">Edit</a>
                <a href="../process/process.php?delete=<?php echo $row['id'];?>" class="btn btn-outline-primary">Delete</a>
              </td>
              <?php  }?>
            </tr>


          </tbody>

        </table>




        <table class="table table-bordered">
          <thead>
            <tr>
              <th >Thursday</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $lessons_result_thursday=$db->query("select * from lesson where fragment='thursday';");
              while($row=$lessons_result_thursday->fetch_assoc()){
              // echo $row['lesson_name'];
              
              ?>
            <tr>
            <td class="h6"><?php echo $row['lesson_name'];?>
                <br><br>
                Time:<?php echo $row['from_time'];?>-<?php echo $row['to_time'];?>
                <br><br>
                Lecturer: <?php echo $row['lecturer'];?>
                <br><br>
                <a href="../lesson/lesson.php?edit=<?php echo $row['id'];?>" class="btn btn-outline-primary">Edit</a>
                <a href="../process/process.php?delete=<?php echo $row['id'];?>" class="btn btn-outline-primary">Delete</a>
              </td>
              <?php  }?>
            </tr>


          </tbody>

        </table>



        <table class="table table-bordered">
          <thead>
            <tr>
              <th >Friday</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $lessons_result_friday=$db->query("select * from lesson where fragment='friday';");
              while($row=$lessons_result_friday->fetch_assoc()){
              // echo $row['lesson_name'];
              
              ?>
            <tr>
            <td class="h6"><?php echo $row['lesson_name'];?>
                <br><br>
                Time:<?php echo $row['from_time'];?>-<?php echo $row['to_time'];?>
                <br><br>
                Lecturer: <?php echo $row['lecturer'];?>
                <br><br>
                <a href="../lesson/lesson.php?edit=<?php echo $row['id'];?>" class="btn btn-outline-primary">Edit</a>
                <a href="../process/process.php?delete=<?php echo $row['id'];?>" class="btn btn-outline-primary">Delete</a>
              </td>
              <?php  }?>
            </tr>


          </tbody>

        </table>






      </div>
    </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>


  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
</body>

<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Start Bootstrap </div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <div class="container-fluid">
      <div class="container">
    <!-- inputs start -->
    <div class="">
      <div class="row justify-content-center">
        <form class="w-50 p-7 border" style="padding: 5%; margin-bottom: 5%; margin-top: 10%;" action="" method="post">
          <div class="form-group row">
            <label for="examname">Name Of Exam</label>
            <input type="text" class="form-control" id="examname" placeholder="name of the exam" required>
            
          </div>
          <div class="form-group row">
            <label for="dateselect">Select date</label>
            <input type="date" class="form-control" id="dateselect" placeholder="Date of the exam" required>
          </div>

          <div class="form-group row">
            <label for="lecturer">Lead Supervisor</label>
            <input type="text" class="form-control" id="lecturer" placeholder="name of lead supervisor" required>
          </div>

          <div class="row">
      <div class="col-sm-4">col-sm-8</div>
      <div class="col-sm-5"><label for="totime">To</label>
            <input type="time" class="form-control" placeholder="To Time" id="totime" required></div>
    </div>
          <!-- <div class="form-group col">

            <label for="fromtime">From</label>
            <input type="time" class="form-control" placeholder="From Time" id="fromtime" required>
          </div>


          <div class="form-group col">
            <label for="totime">To</label>
            <input type="time" class="form-control" placeholder="To Time" id="totime" required>
          </div> -->

          <div class="form-group row">
            <input class="btn btn-outline-primary" type="submit" value="Add">
          </div>
        </form>
      </div>

      <!-- input end -->

      <div class="">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>20/10/2019</th>
              <th>21/10/2019</th>
              <th>22/10/2019</th>
              <th>23/10/2019</th>
              <th>24/10/2019</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <!-- monday -->
              <td class="h6">Object Oriented Programming
                <br><br>
                Time: 10:00AM-11:00AM
                <br><br>
                Supervisor: Mr Muriuki
                <br><br>
                <button type="button" class="btn btn-outline-primary">Edit</button>
                <button type="button" class="btn btn-outline-primary">Delete</button>
              </td>
              <!-- tuesday -->
              <td class="h6">Object Oriented Programming
                <br><br>
                Time: 10:00AM-11:00AM
                <br><br>
                Supervisor: Mr Muriuki
                <br><br>
                <button type="button" class="btn btn-outline-primary">Edit</button>
                <button type="button" class="btn btn-outline-primary">Delete</button>
              </td>
              <!-- wednesday -->
              <td class="h6">Object Oriented Programming
                <br><br>
                Time: 10:00AM-11:00AM
                <br><br>
                Supervisor: Mr Muriuki
                <br><br>
                <button type="button" class="btn btn-outline-primary">Edit</button>
                <button type="button" class="btn btn-outline-primary">Delete</button>
              </td>
              <!-- thursday -->
              <td class="h6">Object Oriented Programming
                <br><br>
                Time: 10:00AM-11:00AM
                <br><br>
                Supervisor: Mr Muriuki
                <br><br>
                <button type="button" class="btn btn-outline-primary">Edit</button>
                <button type="button" class="btn btn-outline-primary">Delete</button>
              </td>
              <!-- friday -->
              <td class="h6">Object Oriented Programming
                <br><br>
                Time: 10:00AM-11:00AM
                <br><br>
                Supervisor: Mr Muriuki
                <br><br>
                <button type="button" class="btn btn-outline-primary">Edit</button>
                <button type="button" class="btn btn-outline-primary">Delete</button>
              </td>

            </tr>

          </tbody>

        </table>

      </div>
    </div>
    <div class="row">
      <div class="col-sm-8">col-sm-8</div>
      <div class="col-sm-4">col-sm-4</div>
    </div>
  </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
</html>




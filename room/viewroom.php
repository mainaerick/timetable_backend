<!DOCTYPE html>
<html>
<?php
// include '../process/process.php';
// include '../logout/checklogin.php';

// check_login();
// $_SESSION['page'] = '../lecturers/index.php';

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>lecturers</title>
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
    // include "../includes/nav.php";
    ?>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <?php
        // include "../includes/sidebar.php"
        ?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="padding: 0%; margin-left: 0%; margin-top: 0%;">

            <div class="">
                <div class="page-content-wrapper container" style="padding: 0%;  margin-top: 3%;">
                    <hr>

                    <div class="col">
                        <form class="col form-inline justify-content-end" style="margin-bottom: 1%;">
                            <input id="search_room" onkeyup="roommyFunction()" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search timetables">
                            <select class="custom-select my-2 my-sm-0" id="select_filter">
                                <option selected>filter by</option>
                                <option value="name">room name</option>
                                <option value="capacity">room capacity</option>

                            </select>
                        </form>
                        <table class="table table-striped" id="table_room">
                            <thead>
                                <tr>
                                    <th onclick="sortTable(0,'table_room')" scope="col"><a href="#">Name</a></th>
                                    <th onclick="sortTable(1,'table_room')" scope="col"><a href="#">Capacity</a></th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $feedback_query = $db->query("select * from room;");
                                if (!empty($feedback_query)) {

                                    $i = 1;
                                    while ($row = $feedback_query->fetch_assoc()) {
                                        $i++;
                                        // echo $row['lesson_name'];

                                ?>
                                        <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['capacity']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="../room/room.php?edit_room=<? echo $row['id']; ?>">Edit</a>
                                                    <a class="dropdown-item" href="../process/process.php?delete_room=<? echo $row['id']; ?>">Delete</a>
                                                </div>
                                            </td>

                                        </tr>
                                <?php }
                                } ?>
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


            <script>
                function roommyFunction() {
                    // Declare variables
                    var input, filter, table, tr, td, i, txtValue, selected_value;
                    input = document.getElementById("search_room");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("table_room");
                    tr = table.getElementsByTagName("tr");
                    selected_value = document.getElementById("select_filter").value;
                    // alert(selected_value);
                    // Loop through all table rows, and hide those who don't match the search query
                    for (i = 0; i < tr.length; i++) {
                        if (selected_value == 'capacity') {
                            td = tr[i].getElementsByTagName("td")[1];

                        } else {
                            td = tr[i].getElementsByTagName("td")[0];

                        }
                        // td = tr[i].getElementById("td-department")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            // alert(txtValue);
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>
</body>


</html>
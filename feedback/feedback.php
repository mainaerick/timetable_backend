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
    if (isset($_GET['occupied'])) {
        // alert($_GET['occupied']);
        alert("sorry " . getlecbyid($db, $_GET['occupied']) . " will not be available at the swapped time");
    }
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
                        <form class="col form-inline justify-content-end" style="margin-bottom: 1%;">
                            <input id="search_feedback" onkeyup="myFunction()" class="form-control mr-sm-2"
                                type="search" placeholder="Search" aria-label="Search timetables">
                            <select class="custom-select my-2 my-sm-0" id="select_filter">
                                <option selected>filter by</option>
                                <option value="content">content</option>
                                <option value="email">email</option>
                                <option value="sent_date">sent-date</option>
                                <option value="res_date">resolved-date</option>

                            </select>
                        </form>
                        <table class="table table-striped" id="feedback_table">
                            <thead>
                                <tr>
                                    <th onclick="sortTable(0,'feedback_table')" scope="col"><a href="#">Content</a></th>
                                    <th onclick="sortTable(1,'feedback_table')" scope="col"><a href="#">Sender Email</a>
                                    </th>
                                    <th onclick="sortTable(2,'feedback_table')" scope="col"><a href="#">Sent date</a>
                                    </th>
                                    <th onclick="sortTable(3,'feedback_table')" scope="col"><a href="#">Resolved
                                            date</a></th>
                                    <th scope="col">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $feedback_query = $db->query("select * from feedback WHERE department='". $_SESSION['ldep_name'] ."'");
                                if (!empty($feedback_query)) {

                                    $i = 1;
                                    while ($row = $feedback_query->fetch_assoc()) {
                                        $i++;
                                        // echo $row['lesson_name'];
                                    
                                ?>
                                <tr>
                                    <td><?php if ($row['feedback_type'] == "Swap") {
                                                    echo getlecbyid($db, $row['sender_id']) . ' ' . $row['content'] . " " . getlecbyid($db, $row['buddy_id']);
                                                } else {
                                                    echo $row['content'];
                                                } ?></td>
                                    <td><?php echo getlecemailbyid($db, $row['sender_id']) ?></td>
                                    <td><?php echo timestamptostr($row['received_date']); ?></td>
                                    <td><?php echo $row['reply_date']; ?></td>

                                    <td>
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <? if ($row['feedback_type'] === "Swap") {

                                                    ?>
                                            <a class="dropdown-item"
                                                href="../process/process.php?resolvefeedback=<?
                                                                                                                                echo $row['id'] .
                                                                                                                                    "
                                                &type=" . $row['feedback_type'] .
                                                                                                                                    "
                                                &senderid=" . $row['sender_id'] .
                                                                                                                                    "
                                                &lesson_id=" . $row['lesson_id'] .
                                                                                                                                    "
                                                &buddy_id=" . $row['buddy_id'] .
                                                                                                                                    "
                                                &buddylesson=" . $row['buddylesson_id']
                                                                                                                                ?>
                                                     ">Resolve</a>
                                            <? } else if ($row['feedback_type'] === "timechange") { ?>
                                            <a class="dropdown-item"
                                                href="../process/process.php?resolvetimechange=<? echo $row['id'] ?>">

                                                Resolve time
                                            </a>

                                            <? } else if ($row['feedback_type'] === "email") { ?>
                                            <a class="dropdown-item"
                                                href="../process/process.php?resolvetimechange=<? echo $row['id'] ?>">
                                                Resolve email
                                            </a>
                                            <? } ?>

                                            <a class="dropdown-item" href="#">Deny resolution</a>
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
            function myFunction() {
                // Declare variables
                var input, filter, table, tr, td, i, txtValue, selected_value;
                input = document.getElementById("search_feedback");
                filter = input.value.toUpperCase();
                table = document.getElementById("feedback_table");
                tr = table.getElementsByTagName("tr");
                selected_value = document.getElementById("select_filter").value;
                // alert(selected_value);
                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    if (selected_value == 'email') {
                        td = tr[i].getElementsByTagName("td")[1];

                    } else if (selected_value == 'sent_date') {
                        td = tr[i].getElementsByTagName("td")[2];

                    } else if (selected_value == 'res_date') {
                        td = tr[i].getElementsByTagName("td")[3];

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
<!DOCTYPE html>
<html lang="en">
<?php
include "../process/process.php";
$_SESSION['page'] = '../department/department.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <?php include "../includes/nav.php"; ?>



    <div class="d-flex" id="wrapper">
        <?php
        // if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) {

        // }
        // else{
        include "../includes/sidebar_admin.php";

        // }
        ?>

        <!-- Page Content -->


        <div id="page-content-wrapper" style="padding: 0%; margin-left: 10%; margin-top: 0%;">
            <div class="container page-content-wrapper">

                <h3>Manage Departments</h3>
                <hr>
                <div class="row">

                    <div class="col">
                        <!-- <button id="addlbtn" class=" btn btn-outline-primary btn-sm">Add Lesson</button> -->
                        <?php
                        if (empty($_SESSION['dep_add_open'])) {
                            // isset($_GET['addlesson']) || isset($_GET['edit']) ||

                        ?>
                            <a id="adddbtn" href="../process/process.php?adddep" type="hidden" class="btn btn-outline-primary btn-sm">Add Department</a>

                        <?php }
                        ?>
                    </div>
                </div>



                <div class="row justify-content-center">

                    <?php
                    if (!empty($_SESSION['dep_add_open']) && $_SESSION['dep_add_open']) {
                        // isset($_GET['addlesson']) || isset($_GET['edit']) ||

                    ?>
                        <div class="col-sm-2">
                            <?php  ?>
                        </div>
                        <div class="col">
                            <?php
                            include 'adddepartment.php';
                            ?>
                        </div>
                        <div class="col-sm-2">
                            <?php  ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- input end -->

                <!-- hide and unhide add lesson button -->


                <!-- buttton select course and year -->




                <!-- TABLE -->


                <?php
                if (!empty($_SESSION['dep_add_open']) && ($_SESSION['dep_add_open'])) {
                } else {
                    include "table_dep.php"; ?>

                <? }
                ?>

                <!-- TABLE END -->
            </div>
            <!-- /#page-content-wrapper -->

        </div>

    </div>



    <script>
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue, selected_value;
            input = document.getElementById("search_department_name");
            filter = input.value.toUpperCase();
            table = document.getElementById("dep_table");
            tr = table.getElementsByTagName("tr");
            // alert(selected_value);
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
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
<!DOCTYPE html>
<html lang="en">
<?php
include "../process/process.php";

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>



    <?php
    // if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) {

    // }
    // else{
    include "../includes/nav.php";

    include "../includes/sidebar_admin.php";

    // }
    ?>

    <div class="container" style="margin-top: 3%;">

        <nav class="navbar navbar-light bg-light">
            <form class="form-inline">
                <input id="search_department_name" onkeyup="myFunction()" class="form-control mr-sm-2" type="search" placeholder="Search department name" aria-label="Search department name">
            </form>
        </nav>
        <? if (isset($_GET['edit_dep'])) {
            include "./adddepartment.php";
        } ?>

        <table class="table table-sm table-bordered" id="dep_table">
            <thead class="thead-dark">
                <tr>
                    <th>Department name</th>
                    <th>Users</th>
                    <th>action</th>

                </tr>
            </thead>
            <tbody>

                <?php
                $results_per_page = 10;
                if (isset($_GET["page"])) {
                    $page  = $_GET["page"];
                } else {
                    $page = 1;
                };
                $start_from = ($page - 1) * $results_per_page;



                $datalist_lesson = $db->query("select * from department ORDER BY name ASC LIMIT $start_from, $results_per_page")  or die($db->error);

                if (!empty($datalist_lesson)) {
                    $i = 0;
                    while ($row = $datalist_lesson->fetch_assoc()) {
                        $i++;
                ?>


                        <tr>


                            <!-- name -->
                            <td class="h6">
                                <?php echo $row['name'] ?>
                            </td>

                            <!-- user email -->
                            <td class="h6">

                                <?php
                                $d_name = $row['name'];
                                $result = $db->query("select * from users where department= '$d_name'");
                                echo $result->num_rows ?>
                            </td>
                            <td class="h6">
                                <a href="../department/department.php?edit_dep=<?php echo $row['name']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>

                            <!-- action -->
                            <!-- <td class="h6">
                        <a href="../course/course.php?edit_course=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="../process/process.php?delete_course=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-outline-primary">Delete</a>
                    </td> -->

                        </tr>
                <?php
                        $sql = "SELECT COUNT(ID) AS total FROM department";
                        $result = $db->query("SELECT COUNT(ID) AS total FROM department")  or die($db->error);
                        $row = $result->fetch_assoc();
                        $total_pages = ceil($row["total"] / $results_per_page);
                        // $total_pages = ceil($total_pages / $results_per_page); 

                    }
                } ?>

            </tbody>

        </table>
        <? for ($i = 1; $i <= $total_pages; $i++) {

            echo "<a class='list-inline-item active' href='./department.php?page=" . $i . "'>" . $i . "</a> ";
        }; ?>
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
                td = tr[i].getElementsByTagName("td")[0];
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
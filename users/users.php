<!DOCTYPE html>
<html lang="en">
<?php
include '../process/process.php';
include '../logout/checklogin.php';
check_login();

?>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>users</title>

    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css">


    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script> -->
</head>

<body>
    <?php
    include "../includes/nav.php";
    ?>

    <?php
    // if (isset($_GET['addlesson']) || isset($_GET['edit']) || isset($_GET['saved'])) {

    // }
    // else{
    include "../includes/sidebar_admin.php";

    // }
    ?>

    <div class="container" style="margin-top: 3%;">
        <nav class="navbar  navbar-light bg-light">
            <form class="form flex-box">
                <input id="search" onkeyup="myFunction()" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <select class="my-2 my-sm-0" id="select_filter">
                    <option selected>filter by</option>
                    <option value="user name">user name</option>
                    <option value="email">email</option>
                    <option value="department">department</option>
                    <option value="status">status</option>

                </select>
            </form>
        </nav>
        <table class="table table-sm table-striped table-hover" id="user_table">
            <thead class="thead-dark">
                <tr>
                    <th onclick="sortTable(0,'user_table')"><a href="#">User name</a></th>
                    <th onclick="sortTable(1,'user_table')"><a href="#">Email</a></th>
                    <th onclick="sortTable(2,'user_table')"><a href="#">Department</a></th>
                    <th>Status</th>

                </tr>
            </thead>
            <tbody>

                <?php
                $datalist_lesson = $db->query("select * from users;") or die($db->error);
                if (!empty($datalist_lesson)) {
                    $i = 0;
                    while ($row = $datalist_lesson->fetch_assoc()) {
                        $i++;
                ?>
                        <tr>
                            <!-- name -->
                            <td class="h6">
                                <?php echo $row['username']; ?>
                            </td>

                            <!-- user email -->
                            <td class="h6">
                                <?php echo $row['email']; ?>
                            </td>

                            <!-- department -->
                            <td id="td-department" class="h6">
                                <?php echo getdepbyid($db, $row['department']); ?>
                            </td>

                            <!-- status -->
                            <td class="h6">
                                <?
                                if ($row['status'] === "not approved") {
                                ?>
                                    <a href="../process/process.php?approve=<?php echo $row['id'];
                                                                            ?>&user_email=<? echo $row['email']; ?>&user_dep=<? echo str_replace("&", "%26", $row['department']);
                                                                                                                                ?>" class="btn btn-sm btn-outline-primary">Approve</a>
                                <? } else { ?>
                                    <a href="../process/process.php?dis_approve=<?php echo $row['id'];
                                                                                ?>" class="btn btn-sm btn-outline-primary">User Approved</a>
                                <?
                                }
                                ?>


                            </td>



                            <!-- action -->
                            <!-- <td class="h6">
                        <a href="../course/course.php?edit_course=<?php
                                                                    // echo $row['id']; 
                                                                    ?>"
                            class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="../process/process.php?delete_course=<?php
                                                                        //  echo $row['id']; 
                                                                        ?>"
                            class="btn btn-sm btn-outline-primary">Delete</a>
                    </td> -->

                        </tr>
                <?php  }
                } ?>

            </tbody>

        </table>
    </div>

    <script>
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue, selected_value;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("user_table");
            tr = table.getElementsByTagName("tr");
            selected_value = document.getElementById("select_filter").value;
            // alert(selected_value);
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                if (selected_value == 'department') {
                    td = tr[i].getElementsByTagName("td")[2];

                } else if (selected_value == 'username') {
                    td = tr[i].getElementsByTagName("td")[0];

                } else if (selected_value == 'email') {
                    td = tr[i].getElementsByTagName("td")[1];

                } else if (selected_value == 'status') {
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

        // function sendmail() {
        //     var email=
        //     $.ajax({
        //         url: '../process/process.php.php?sendmail',
        //         data: data,
        //         type: 'POST',
        //         success: function(data) {
        //             // For Notification
        //             document.getElementById("sendMailForm").reset();
        //             var $alertDiv = $(".mailResponse");
        //             $alertDiv.show();
        //             $alertDiv.find('.alert').removeClass('alert-danger alert-success');
        //             $alertDiv.find('.mailResponseText').text("");
        //             if (data.error) {
        //                 $alertDiv.find('.alert').addClass('alert-danger');
        //                 $alertDiv.find('.mailResponseText').text(data.message);
        //             } else {
        //                 $alertDiv.find('.alert').addClass('alert-success');
        //                 $alertDiv.find('.mailResponseText').text(data.message);
        //             }
        //         }
        //     });
        // }
    </script>



    <!-- <script type="text/javascript">
    $(document).ready(function() {
        $('.searching .col .search-box input[type="text"]').on("keyup input", function() {
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $('.result');
            // $(this).siblings(".result");
            var availdep = $(this).siblings(".dep_avail");
            if (inputVal.length) {
                $.post("process/process.php", {
                    dep_search: inputVal

                }).done(function(data) {
                    // Display the returned data in browser
                    resultDropdown.html(data);
                    availdep.text("");
                });
            } else {
                resultDropdown.empty();
            }
        });

        // Set search input value on click of result item
        $(document).on("click", ".result a", function() {
            $(".searching .col .search-box").find('input[type="text"]').val($(this).text());
            $(this).parents(".result").empty();
        });
    });
    </script> -->
</body>

</html>
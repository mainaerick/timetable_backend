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
    <title>Login</title>

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
        
        <table class="table table-sm table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>User name</th>
                    <th>Email</th>
                    <th>Department</th>
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
                    <!-- number -->
                    <td class="h6">
                        <?php echo $i; ?>

                    </td>

                    <!-- name -->
                    <td class="h6">
                        <?php echo $row['username'] ?>
                    </td>

                    <!-- user email -->
                    <td class="h6">
                        <?php echo $row['email'] ?>
                    </td>

                    <!-- department -->
                    <td class="h6">
                        <?php echo $row['department'] ?>
                    </td>

                    <!-- status -->
                    <td class="h6">
                        <?php 
                        if($row['status']==="not approved"){?>
                            <a href="../process/process.php?approve=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-outline-primary">Approve</a>
                        <?}
                        else{
                            ?>
                            <a href="../process/process.php?dis_approve=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-outline-primary">User Approved</a>
                            <?
                        }
                        ?>
                        
                        
                    </td>



                    <!-- action -->
                    <!-- <td class="h6">
                        <a href="../course/course.php?edit_course=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="../process/process.php?delete_course=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-outline-primary">Delete</a>
                    </td> -->

                </tr>
                <?php  }
                } ?>

            </tbody>

        </table>
    </div>



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
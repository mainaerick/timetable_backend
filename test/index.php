<!DOCTYPE html>
<html lang="en">
<?php
include '../process/process.php';
include '../logout/checklogin.php';
check_login();
$_SESSION['page'] = '../lesson/lesson.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <?php
    include "../includes/nav.php";
    ?>
    <!-- <div class="row">
        <div class="col-lg-12">
            <input type="text" name="search" id="search" autocomplete="off" placeholder="search department....">
            <div class="autocomplete">
                <div id="output"></div>
            </div>
            
        </div>
    </div> -->




   







    <!-- <script type="text/javascript">
        $(document).ready(function() {
            $("#search").keyup(function() {
                var dep_search = $(this).val();
                if (dep_search != "") {

                    $.ajax({
                        url: '../process/process.php',
                        method: 'POST',
                        data: {
                            dep_search: dep_search
                        },
                        success: function(data) {


                            $('#output').html(data);

                            $('#output').css('display', 'block');

                            $("#search").focusout(function() {
                                $('#output').css('display', 'none');
                            });
                            $("#search").focusin(function() {
                                $('#output').css('display', 'block');
                            });
                        }
                    });
                } else {
                    $('#output').css('display', 'none');
                }
            });
        });
    </script> -->
</body>

</html>
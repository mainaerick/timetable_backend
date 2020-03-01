<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css">


    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">


    <script type="text/javascript" src="../js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>


    <script src="../dist/sweetalert.js"></script>
    <link rel="stylesheet" href="../dist/sweetalert.css">
    <!--.......................-->
</head>

<body>



    <nav class="navbar-expand-lg sticky-top navbar navbar-light bg-dark">

        <!-- <a class="navbar-brand" href="#">Navbar w/ text</a> -->
        <a class="navbar-brand" href="#" style="color: #fff;">TIMETABLE MANAGEMENT SYSTEM <span class="sr-only">(current)</span></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <!-- <li class="nav-item active">
                    <a class="navbar-brand" href="#" style="color: #fff;">Home <span class="sr-only">(current)</span></a>
                </li> -->
            </ul>

            <!-- profile and logout -->
            <? if (empty($_SESSION['id'])) {
            } else { ?>
                <span class="navbar-text  my-2 my-sm-0">


                    <div class="dropdown">
                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Profile
                        </button>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                            <button type="button" class="dropdown-item" data-toggle="tooltip" data-placement="left" title="<?php echo $_SESSION['ldep_name']; ?>">
                                User</button>
                            <a class="dropdown-item" href="../logout/logout.php">Log out</a>

                        </div>
                    </div>
                </span>
            <? } ?>
        </div>
    </nav>

    <script language="javascript">
        // $(function() {
        //             $('[data-toggle="tooltip"]').tooltip() {

        //             }
        //         }
        $(document).ready(function() {
            $(".tr_lavailable").click(function() {
                //find content of different elements inside a row.
                var unitname = $(this).closest('tr').find('.name_unit').text();
                var unitcode = $(this).closest('tr').find('.code_unit').text();
                var unitlec = $(this).closest('tr').find('.lec_unit').text();

                //assign above variables text1,text2 values to other elements.
                $("#examname").val(unitname);
                $("#examcode").val(unitcode);
                $("#examsupervisor").val(unitlec);

                $("#table_examc").display("none");
            });
        });
        $(document).ready(function() {
            $(".tr_lecavailable").click(function() {
                // alert("");
                //find content of different elements inside a row.
                var lec_name = $(this).closest('tr').find('.lec_name').text();
                // var unitcode = $(this).closest('tr').find('.code_unit').text();
                // var unitlec = $(this).closest('tr').find('.lec_unit').text();

                // //assign above variables text1,text2 values to other elements.
                $("#lecturer").val(lec_name);
                // $("#examcode").val(unitcode);
                // $("#examsupervisor").val(unitlec);

                $("#table_lessonl").display = "none";
            });
        });

        // $("close_lesson").click(function() {
        //         //find content of different elements inside a row.

        //         $("#form_lesson").hide();
        //     });
    </script>

    <script type="text/javascript">
        $(function() {
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
        });
    </script>



</body>

</html>
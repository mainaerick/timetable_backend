<!DOCTYPE html>
<html lang="en">
<?php
include '../process/process.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css">


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="../js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
</head>

<body>


    <div class="container">
        <div class="row justify-content-center">
            <form class="border border-dark needs-validation" style="padding: 5%; margin-top: 10%;" action="../process/process.php" method="POST">

                <a class="form-group row justify-content-end" href="../">Login</a>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control email" id="email" placeholder="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                </div>
                <div class="valid-feedback feedback-pos">
                    Looks good!
                </div>
                <div class="invalid-feedback feedback-pos">
                    Please input valid email ID
                </div>



                <div class="search-box form-group">
                    <label for="department">Department</label>
                    <input type="text" name="department" autocomplete="off" placeholder="Search department..." />

                </div>


                <div class="result form-group alert alert-primary"></div>
                <div class="dep_avail form-group" style="color: red;">
                    <?php
                    if (empty($_SESSION['no_dep'])) {
                    } else {
                        echo $_SESSION['no_dep'];
                    } ?>
                </div>


                <div class="form-group row justify-content-center">
                    <input class="btn btn-outline-primary" type="submit" name="signup" value="signup">
                </div>

                <?php
                if (isset($_SESSION['signup_err'])) { ?>

                    <div class="form-group alert alert-warning" <?= $_SESSION['signup_err'] ?>>
                    <?php
                    echo $_SESSION['signup_err'];
                    unset($_SESSION['signup_err']);
                }
                    ?>

                    </div>
            </form>

        </div>
    </div>


    <script type="text/javascript">

        $(document).ready(function() {
            $('.search-box input[type="text"]').on("keyup input", function() {
                /* Get input value on change */
                var inputVal = $(this).val();
                var resultDropdown = $('.result');
                // $(this).siblings(".result");
                var availdep = $(this).siblings(".dep_avail");
                if (inputVal.length) {
                    $.post("../process/process.php", {
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
                $(".search-box").find('input[type="text"]').val($(this).text());
                $(this).parents(".result").empty();
            });
        });
    </script>
</body>

</html>
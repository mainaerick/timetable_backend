<!DOCTYPE html>
<html lang="en">
<?php 
include 'process/connect.php';
include 'process/process.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css">


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body>
<? include "includes/nav.php";
 ?>
    <div class="container">
        <div>
            <div class="row justify-content-center">

                <form class="border border-dark w-30 p-7 border" style="padding: 5%; margin-top: 10%;"
                    action="process/process.php" method="POST">

                    <a class="form-group row justify-content-end" href="signup/sinup.php">signup</a>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                            required>
                    </div>


                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="logpass" name="password" placeholder="Password"
                            required>
                    </div>
                    <div class="form-group row justify-content-center">
                    <button type="button" class="dropdown-item col" data-toggle="modal" data-placement="left" title="" data-target="#myModal_passchange">
                                Forgot Password?</button> 
                        <input class="btn btn-outline-primary col" type="submit" name="login" value="Login">
                        
                    </div>
                    
                    
                    <?php

                    if (isset($_SESSION['login_err'])) {

                        ?>

                    <div class="form-group alert alert-warning" <?= $_SESSION['login_err'] ?>>
                        <?php
                            echo $_SESSION['login_err'];
                            unset($_SESSION['login_err']);
                        }

                        ?>

                    </div>
                </form>

            </div>
        </div>
    </div>
<!-- Pawsword change modal -->
<div id="myModal_passchange" class="modal fade" role="dialog" data-backdrop="false">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Password</h4>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="border border-dark w-30 p-7 border" style="padding: 5%; margin-top: 10%;" action="process/process.php" method="POST">
                                        <div class="form-group">
                                                <label for="new_pass">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                            </div>    
                                        <div class="form-group">
                                                <label for="new_pass">New Password</label>
                                                <input type="password" class="form-control" id="new_pass" name="new_pass" placeholder="New Password" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="con_pass">Confirm Password</label>
                                                <input type="password" class="form-control" id="con_pass" name="confirm_password" placeholder="Comfirm Password" required>
                                            </div>
                                            <div class="form-group row justify-content-center">
                                                <input id="change_pass" class="btn btn-outline-primary" type="submit" name="reset_pass" value="Reset" disabled>
                                            </div>
                                            <span id='message'></span>
                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>
</body>


<script>

$('#new_pass, #con_pass').on('keyup', function() {
            if ($('#new_pass').val() == $('#con_pass').val()) {
                $('#message').html('Matching').css('color', 'green');
                // $('#change_pass').disabled = false;
                $( "#change_pass" ).prop( "disabled", false );
            } else{
                $('#message').html('Not Matching').css('color', 'red');
                // $('#change_pass').disabled = true;
                $( "#change_pass" ).prop( "disabled", true );

            }
        });
</script>

</html>
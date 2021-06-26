<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css">


    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script> -->



    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet"> -->


    <!-- datepicker tarruda -->
    <link rel="stylesheet" type="text/css" media="screen" href="../datepicker/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="../dist/sweetalert.css">
    <!--.......................-->


    <nav class="navbar-expand-lg sticky-top navbar navbar-light bg-dark">

        <!-- <a class="navbar-brand" href="#">Navbar w/ text</a> -->
        <a class="navbar-brand" href="#" style="color: #fff;">TIMETABLE MANAGEMENT SYSTEM <span
                class="sr-only">(current)</span></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto" style="margin-left: 20%">
                <li class="nav-item active">
                    <?php
                    if (empty($_SESSION['ldep_name'])) {
                        echo '<h5><span class="badge badge-pill badge-secondary">' . "Please select a department" . '</span></h5>';
                    } else {
                        echo '<h5><span class="badge badge-pill badge-secondary">' . getdepbyid($db, $_SESSION['ldep_name']) . '</span></h5>';
                    } ?> </li>
            </ul>

            <!-- profile and logout -->
            <? if (empty($_SESSION['id'])) {
            } else { ?>
            <span class="navbar-text  my-2 my-sm-0">


                <div class="dropdown">
                    <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Profile
                    </button>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                        <button type="button" class="dropdown-item" data-toggle="modal" data-placement="left" title=""
                            data-target="#myModal_usernamechange">
                            Edit Profile</button>
                        <button type="button" class="dropdown-item" data-toggle="modal" data-placement="left" title=""
                            data-target="#myModal_passchange">
                            Change Password</button>
                        <a class="dropdown-item" href="../logout/logout.php">Log out</a>

                    </div>


                    <!-- Username and email change modal content-->
                    <div id="myModal_usernamechange" class="modal fade" role="dialog" data-backdrop="false">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Profile Update</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <h5 class="modal-title"></h5>
                                <? $u_id=$_SESSION['id']; ?>
                                <div class="modal-body">
                                    <form class="border border-dark w-30 p-7 border"
                                        style="padding: 5%; margin-top: 10%;" action="../process/process.php"
                                        method="POST">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="changeusername"
                                                placeholder="Username" value="<?echo  get_usernamebyid($db,$u_id); ?>"
                                                required>
                                        </div>


                                        <div class="form-group">
                                            <label for="changeemail">Email</label>
                                            <input type="text" class="form-control" id="logpass" name="changeemail"
                                                placeholder="Email" value="<?echo  get_useremailbyid($db,$u_id); ?>"
                                                required>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <input class="btn btn-outline-primary" type="submit" name="changeusername"
                                                value="Update">
                                        </div>

                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
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
                                    <form class="border border-dark w-30 p-7 border"
                                        style="padding: 5%; margin-top: 10%;" action="../process/process.php"
                                        method="POST">
                                        <div class="form-group">
                                            <label for="new_pass">New Password</label>
                                            <input type="password" class="form-control" id="new_pass" name="new_pass"
                                                placeholder="New Password" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="con_pass">Confirm Password</label>
                                            <input onchange="check_pass()" type="password" class="form-control"
                                                id="con_pass" name="confirm_password" placeholder="Comfirm Password"
                                                required>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <input id="change_pass" class="btn btn-outline-primary" type="submit"
                                                name="changepass" value="Update" disabled>
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
                </div>
            </span>
            <? } ?>
        </div>

    </nav>
</head>


<body>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="../dist/sweetalert.js"></script>

    <script type="text/javascript" src="../js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous">
    </script> -->
    <!-- datepicker tarruda -->
    <script type="text/javascript" src="../datepicker/js/bootstrap-datetimepicker.min.js">
    </script>

    <script language="javascript">
    // $(document).ready(function() {
    //     $("#subject").click(function() {
    //         $("#unit_list").load("../lesson/units_avail.php");
    //     });
    // });
    // add or remove departments to school
    // function check_pass() {
    //     if (document.getElementById('new_pass').value ==
    //         document.getElementById('con_pass').value) {

    //         document.getElementById('change_pass').disabled = false;
    //     } else {
    //         document.getElementById('change_pass').disabled = true;
    //     }
    // }

    $('#new_pass, #con_pass').on('keyup', function() {
        if ($('#new_pass').val() == $('#con_pass').val()) {
            $('#message').html('Matching').css('color', 'green');
            // $('#change_pass').disabled = false;
            $("#change_pass").prop("disabled", false);
        } else {
            $('#message').html('Not Matching').css('color', 'red');
            // $('#change_pass').disabled = true;
            $("#change_pass").prop("disabled", true);

        }
    });

    $(document).ready(function() {
        $('#subject').click(function() {
            $.get('../lesson/units_avail.php', function(data) {
                $('#side_view').html(data);
            });
        });
    });


    $(document).ready(function() {
        $('#stdno').click(function() {
            $.get('../lesson/roomsavail.php', function(data) {
                $('#side_view').html(data);
            });
        });
    });
    $(document).ready(function() {
        $('#lecturer').click(function() {
            $.get('../lesson/lecturer_available.php', function(data) {
                $('#side_view').html(data);
            });
        });
    });

    $(document).ready(function() {
        $('#viewexamunits').click(function() {
            $.get('../exams/exam_course.php', function(data) {
                $('#side_view').html(data);
            });
        });
    });

    $(document).ready(function() {
        $(".tr_lavailable").click(function() {
            //find content of different elements inside a row.
            var unitname = $(this).closest('tr').find('.name_unit').text();
            var unitcode = $(this).closest('tr').find('.code_unit').text();
            var unitlec = $(this).closest('tr').find('.lec_unit').text();
            var unitcapacity = $(this).closest('tr').find('.std_no').text();
            var unitlec_reg = $(this).closest('tr').find('.lec_reg').text();


            //assign above variables text1,text2 values to other elements.
            $("#examname").val(unitname);
            $("#examcode").val(unitcode);
            $("#examsupervisor").val(unitlec);
            $("#std_no").val(unitcapacity);
            // $("#room").val("");
            $("#examsupervisor_reg").val(unitlec_reg);

            var input = document.getElementById("std_no");
            var filter = input.value;
            if (!filter.length) {
                // alert("Please select a Lesson to view rooms");
            }
            var recordCount = 2;

            recordCount = recordCount + 2;
            $.ajax({
                type: "GET",
                url: "../process/process.php",
                data: {
                    rooms: "",
                    stud_no: filter
                },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    var trHTML = '';
                    $('#table_room').empty();

                    $.each(response, function(i, item) {
                        // alert(item.name);
                        trHTML +=
                            '<tr class="tr_roomavailable"><td class="room_name">' +
                            item.name + '</td><td class="">' + item.capacity +
                            '</td></tr>';
                        if (i == 0) {
                            $("#room").val(item.name);
                        }


                    });
                    // $('#table_room').append(trHTML);
                },
                error: function(e) {
                    console.log(e.error);
                }
            });

            $("#table_examc").display("none");
        });
    });
    $('body').delegate('.tr_lecavailable', 'click', function() {
        // $(document).ready(function() {
        //     $(".tr_lecavailable").click(function() {
        // alert("");
        //find content of different elements inside a row.
        var lec_name = $(this).closest('tr').find('.lec_name').text();
        var lec_reg = $(this).closest('tr').find('.lec_reg').text();
        // var unitlec = $(this).closest('tr').find('.lec_unit').text();

        // //assign above variables text1,text2 values to other elements.

        $("#lecturer").val(lec_name);
        $("#lec_reg").val(lec_reg);

        // $("#examcode").val(unitcode);
        // $("#examsupervisor").val(unitlec);

        $("#table_lessonl").display = "none";
        // });
    });
    $('body').delegate('.tr_roomavailable', 'click', function() {

        // $(document).ready(function() {
        //     $(".tr_roomavailable").click(function() {
        // alert("");
        //find content of different elements inside a row.
        var room_name = $(this).closest('tr').find('.room_name').text();
        // var unitcode = $(this).closest('tr').find('.code_unit').text();
        // var unitlec = $(this).closest('tr').find('.lec_unit').text();
        // //assign above variables text1,text2 values to other elements.
        $("#room").val(room_name);
        // $("#examcode").val(unitcode);
        // $("#examsupervisor").val(unitlec);
        var input = document.getElementById("stdno");
        var filter = input.value;
        if (!filter.length) {
            // alert("Please select a Lesson to view rooms");
        }
        var recordCount = 2;

        recordCount = recordCount + 2;
        $.ajax({
            type: "GET",
            url: "../process/process.php",
            data: {
                rooms: "",
                stud_no: filter
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                var trHTML = '';
                $('#table_room').empty();

                $.each(response, function(i, item) {
                    // alert(item.name);
                    trHTML +=
                        '<tr class="tr_roomavailable"><td class="room_name">' +
                        item.name + '</td><td class="">' + item.capacity +
                        '</td></tr>';
                    if (i == 0) {
                        $("#room").val(item.name);
                    }


                });
                // $('#table_room').append(trHTML);
            },
            error: function(e) {
                console.log(e.error);
            }
        });

        $("#table_lessonl").display = "none";
        // });
    });


    $('body').delegate('.tr_unitavailable', 'click', function() {

        // $(document).ready(function() {
        //     $(".tr_roomavailable").click(function() {
        // alert("");
        //find content of different elements inside a row.
        var unit_name = $(this).closest('tr').find('.name').text();
        var unitcode = $(this).closest('tr').find('.code').text();
        var unitstud = $(this).closest('tr').find('.std_no').text();

        // var unitlec = $(this).closest('tr').find('.lec_unit').text();
        // //assign above variables text1,text2 values to other elements.
        $("#subject").val(unit_name);
        $("#lcode").val(unitcode);
        $("#stdno").val(unitstud);


        var input = document.getElementById("stdno");
        var filter = input.value;
        if (!filter.length) {
            // alert("Please select a Lesson to view rooms");
        }
        var recordCount = 2;

        recordCount = recordCount + 2;
        $.ajax({
            type: "GET",
            url: "../process/process.php",
            data: {
                rooms: "",
                stud_no: filter
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function(response) {
                var trHTML = '';
                $('#table_room').empty();

                $.each(response, function(i, item) {
                    // alert(item.name);
                    trHTML +=
                        '<tr class="tr_roomavailable"><td class="room_name">' +
                        item.name + '</td><td class="">' + item.capacity +
                        '</td></tr>';
                    if (i == 0) {
                        $("#room").val(item.name);
                    }


                });
                // $('#table_room').append(trHTML);
            },
            error: function(e) {
                console.log(e.error);
            }
        });


        // $("#examcode").val(unitcode);
        // $("#examsupervisor").val(unitlec);

        $("#table_lessonl").display = "none";
        // });
    });
    // search room
    function searchroom_l() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue, selected_value;
        input = document.getElementById("room");
        filter = input.value.toUpperCase();
        table = document.getElementById("table_room");
        tr = table.getElementsByTagName("tr");
        // selected_value = document.getElementById("select_filter").value;
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

    // search lecturer
    function searchlecturer_l() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue, selected_value;
        input = document.getElementById("lecturer");
        filter = input.value.toUpperCase();
        table = document.getElementById("table_lec");
        tr = table.getElementsByTagName("tr");
        // selected_value = document.getElementById("select_filter").value;
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


    $(function() {
        $('#fromtimepicker').datetimepicker({
            pickDate: false,
            pick12HourFormat: true, // enables the 12-hour format time picker
            pickSeconds: false
        });
    });
    $(function() {
        $('#totimepicker').datetimepicker({
            pickDate: false,
            pick12HourFormat: true, // enables the 12-hour format time picker
            pickSeconds: false
        });
    });
    // room input_click
    $(document).ready(function() {
        var recordCount = 2;
        $("#stdno").keyup(function() {
            var input = document.getElementById("stdno");
            var filter = input.value;
            if (!filter.length) {
                // alert("Please select a Lesson to view rooms");
            }
            recordCount = recordCount + 2;
            $.ajax({
                type: "GET",
                url: "../process/process.php",
                data: {
                    rooms: "",
                    stud_no: filter
                },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    var trHTML = '';
                    $('#table_room').empty();

                    $.each(response, function(i, item) {
                        // alert(item.name);
                        trHTML +=
                            '<tr class="tr_roomavailable"><td class="room_name">' +
                            item.name + '</td><td class="">' + item.capacity +
                            '</td></tr>';
                    });
                    $('#table_room').append(trHTML);
                },
                error: function(e) {
                    console.log(e.error);
                }
            });
        });
    });
    // get values from examfrom date and to date
    //  then perform auto fill date and time

    $(document).ready(function() {
        var recordCount = 2;
        $("#stdno").click(function() {
            var input = document.getElementById("stdno");
            var filter = input.value;
            if (!filter.length) {
                // alert("Please select a Lesson to view rooms");
            }
            recordCount = recordCount + 2;
            $.ajax({
                type: "GET",
                url: "../process/process.php",
                data: {
                    rooms: "",
                    stud_no: filter
                },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function(response) {
                    var trHTML = '';
                    $('#table_room').empty();

                    $.each(response, function(i, item) {
                        // alert(item.name);
                        trHTML +=
                            '<tr class="tr_roomavailable"><td class="room_name">' +
                            item.name + '</td><td class="">' + item.capacity +
                            '</td></tr>';
                    });
                    $('#table_room').append(trHTML);
                },
                error: function(e) {
                    console.log(e.error);
                }
            });
        });
    });

    function sortTable(n, tablename) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById(tablename);
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("td")[n];
                y = rows[i + 1].getElementsByTagName("td")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */

                if (dir == "asc") {
                    if (tablename == "table_room" && n == 1) {
                        if (Number(x.innerHTML) > Number(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }

                } else if (dir == "desc") {
                    if (tablename == "table_room" && n == 1) {
                        if (Number(x.innerHTML) < Number(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }

                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }

    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();


    $(function() {
        // $('#fromtime').datetimepicker({
        //     pickDate: false
        // });

        // $('.datetime').datetimepicker({
        //     format: 'hh:ii:00',
        //     autoclose: true,
        //     startView: 0,
        //     pickerPosition: "bottom-left",
        //     pickDate: false
        // });
    });
    // $("close_lesson").click(function() {
    //         //find content of different elements inside a row.

    //         $("#form_lesson").hide();
    // });
    </script>

    <script type="text/javascript">
    function printing(tablename) {
        // window.print();


        // You can use simple JavaScript to print a specific div from a page.

        // var prtContent = document.getElementById("table_lessons");
        // var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        // WinPrint.document.write(prtContent.outerHTML);
        // WinPrint.document.close();
        // WinPrint.focus();
        // WinPrint.print();
        // WinPrint.close();

        // var divToPrint = document.getElementById('table_lessons');
        // newWin = window.open("");
        // newWin.document.write(divToPrint.outerHTML);
        // newWin.print();
        // newWin.close();
        var divToPrint = document.getElementById(tablename);
        var htmlToPrint = '' +
            '<style type="text/css">' +
            'table th, table td {' +
            'border:1px solid #000;' +
            'padding:0.5em;' +
            '}' +
            '</style>';
        htmlToPrint += divToPrint.outerHTML;
        newWin = window.open("");
        newWin.document.write(htmlToPrint);
        newWin.print();
        newWin.close();

    }
    </script>



</body>

</html>
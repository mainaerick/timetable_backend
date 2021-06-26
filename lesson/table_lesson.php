<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <!-- Tables start -->
    <div class="flex-row justify-content-start" style="width: 100%;">

        <!-- <a href="../lesson/lesson.php?addlesson" id="addlbtn" type="hidden" class="btn btn-outline-primary" style="margin-top: 2%; margin-bottom: 2%;">Add Lesson</a> -->

        <a id="print" href="../lesson/lesson.php?printlesson" type="hidden" class="btn btn-outline-primary btn-sm"
            style="margin-top: 2%; margin-bottom: 2%;">Print view</a>

        <form class="col form-inline justify-content-end" style="margin-bottom: 2%;">
            <select class="custom-select my-2 my-sm-0" id="select_filter" onchange="onchangefilter()">
                <option selected>filter table</option>
                <option value="lecturer">lecturer</option>
                <option value="room">room</option>

            </select>


            <div class="dropdown" id="select_filter_room" style="display: none; ">
                <a onclick="myFunction()" class="custom-select">Filter by room</a>
                <div id="myDropdown" class="dropdown-content">
                    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">

                    <?php $roomquery = $db->query("select * from room") or die($db->error);
                    while ($roomrow = $roomquery->fetch_assoc()) {
                    ?>
                    <a href="lesson.php?filter_value=<?php echo $roomrow['id'] ?>&col_value=room">
                        <?php echo $roomrow['name']; ?>
                    </a>
                    <?php } ?>
                </div>
            </div>

            <div class="dropdown" id="select_filter_lecturer" style="display: block;">
                <a onclick="lecmyFunction()" class="custom-select">Filter by lecturer</a>
                <div id="lecDropdown" class="dropdown-content">
                    <a href="print_schooltimetable.php">Select lecturer</a>

                    <input type="text" placeholder="Search.." id="myInputlec" onkeyup="filterFunctionlec()">

                    <?php $lecquery = $db->query("select * from lecturer") or die($db->error);
                    while ($lecrow = $lecquery->fetch_assoc()) {


                    ?>
                    <a href="lesson.php?filter_value=<?php echo $lecrow['id'] ?>&col_value=lecturer">
                        <?php echo $lecrow['name']; ?>
                    </a>
                    <?php } ?>
                </div>
            </div>



            <!-- <input id="search_lessons" onkeyup="myFunction()" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
            <!-- <select class="my-2 my-sm-0" id="select_filter">
                    <option selected>filter by</option>
                    <option value="name">name</option>
                    <option value="code">code</option>
                    <option value="lecturer">lecturer</option>
                    <option value="time">time</option>
                </select> -->
            <!-- <select class="my-2 my-sm-0" id="select_filter">
                    <option selected value="monday">monday</option>
                    <option value="tuesday">tuesday</option>
                    <option value="wednesday">wednesday</option>
                    <option value="thursday">thursday</option>
                    <option value="friday">friday</option>

                </select> -->
        </form>
    </div>
    <div style="margin: 0%;" id="hidden" class="">
        <table class="table table-sm table-bordered table-responsive" id="prtable_lessons">
            <thead>
                <th>Days</th>
                <?php
                $theadtimestart = array();
                $theadtimestop = array();
                $start_time = '07:00';  //start time as string
                $end_time = '19:00';
                $start = DateTime::createFromFormat('H:i', $start_time);  //create date time objects

                $end = DateTime::createFromFormat('H:i', $end_time);  //create date time objects

                for ($i = $start; $i < $end;)  //for loop 

                {
                    $start_t = $i->format('H:i');   //take hour and minute
                    $i->modify('60 minutes');      //add 20 minutes
                    $stop_t = $i->format('H:i');     //take hour and minute
                    $dispstart = DateTime::createFromFormat('H:i', $start_t);  //create date time objects

                    $dispend = DateTime::createFromFormat('H:i', $stop_t);


                    $time_set = $dispstart->format('ha') . "-" . $dispend->format('ha');

                    echo '<th>' . $time_set . '</th>';
                    // filltable_($db, $start_t, $stop_t, 'monday');
                    // print_r($time_set);
                    array_push($theadtimestart, $start_t);
                    array_push($theadtimestop, $stop_t);
                }  ?>
                <!-- <th>07:00am-08:00am</th>
                                <th>08:00am-09:00am</th>
                                <th>09:00am-10:00am</th>
                                <th>10:00am-11:00am</th>
                                <th>11:00am-12:00pm</th>
                                <th>12:00pm-01:00pm</th>
                                <th>01:00pm-02:00pm</th>
                                <th>02:00pm-03:00pm</th>
                                <th>03:00pm-04:00pm</th>
                                <th>04:00pm-05:00pm</th>
                                <th>05:00pm-06:00pm</th>
                                <th>06:00pm-07:00pm</th> -->
            </thead>

            <tr>
                <!-- Monday -->

                <!-- td1 -->
                <th>Monday</th>

                <td>

                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[0], $theadtimestop[0], 'monday'); ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[1], $theadtimestop[1], 'monday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[2], $theadtimestop[2], 'monday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[3], $theadtimestop[3], 'monday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[4], $theadtimestop[4], 'monday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[5], $theadtimestop[5], 'monday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[6], $theadtimestop[6], 'monday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[7], $theadtimestop[7], 'monday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[8], $theadtimestop[8], 'monday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[9], $theadtimestop[9], 'monday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[10], $theadtimestop[10], 'monday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[11], $theadtimestop[11], 'monday') ?>
                </td>




            </tr>

            <tr>
                <th>Tuesday</th>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[0], $theadtimestop[0], 'tuesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[1], $theadtimestop[1], 'tuesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[2], $theadtimestop[2], 'tuesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[3], $theadtimestop[3], 'tuesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[4], $theadtimestop[4], 'tuesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[5], $theadtimestop[5], 'tuesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[6], $theadtimestop[6], 'tuesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[7], $theadtimestop[7], 'tuesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[8], $theadtimestop[8], 'tuesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[9], $theadtimestop[9], 'tuesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[10], $theadtimestop[10], 'tuesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[11], $theadtimestop[11], 'tuesday') ?>
                </td>

            </tr>
            <tr>
                <th>Wednesday</th>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[0], $theadtimestop[0], 'wednesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[1], $theadtimestop[1], 'wednesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[2], $theadtimestop[2], 'wednesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[3], $theadtimestop[3], 'wednesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[4], $theadtimestop[4], 'wednesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[5], $theadtimestop[5], 'wednesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[6], $theadtimestop[6], 'wednesday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[7], $theadtimestop[7], 'wednesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[8], $theadtimestop[8], 'wednesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[9], $theadtimestop[9], 'wednesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[10], $theadtimestop[10], 'wednesday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[11], $theadtimestop[11], 'wednesday') ?>
                </td>
            </tr>
            <tr>
                <th>Thursday</th>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[0], $theadtimestop[0], 'thursday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[1], $theadtimestop[1], 'thursday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[2], $theadtimestop[2], 'thursday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[3], $theadtimestop[3], 'thursday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[4], $theadtimestop[4], 'thursday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[5], $theadtimestop[5], 'thursday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[6], $theadtimestop[6], 'thursday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[7], $theadtimestop[7], 'thursday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[8], $theadtimestop[8], 'thursday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[9], $theadtimestop[9], 'thursday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[10], $theadtimestop[10], 'thursday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[11], $theadtimestop[11], 'thursday') ?>
                </td>
            </tr>


            <tr>
                <th>Friday</th>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[0], $theadtimestop[0], 'friday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[1], $theadtimestop[1], 'friday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[2], $theadtimestop[2], 'friday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[3], $theadtimestop[3], 'friday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[4], $theadtimestop[4], 'friday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[5], $theadtimestop[5], 'friday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[6], $theadtimestop[6], 'friday') ?>
                </td>

                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[7], $theadtimestop[7], 'friday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[8], $theadtimestop[8], 'friday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[9], $theadtimestop[9], 'friday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[10], $theadtimestop[10], 'friday') ?>
                </td>
                <td>
                    <?php echo filltable_($db, $dept_name, $ltablecourse, $lyear, $lsemester, $theadtimestart[11], $theadtimestop[11], 'friday') ?>
                </td>
            </tr>
        </table>


    </div>







</body>

</html>
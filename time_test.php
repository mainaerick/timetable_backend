<?php
// include 'process/connect.php';
// include 'process/process.php';

$start_time = '07:00';  //start time as string
$end_time = '19:00';  //end time as string
$booked = array(); 
// array('12:00-13:00', '14:00-15:00');    //booked slots as arrays

$result=$db->query("select * from lesson") or die($db->error);
if($result->num_rows){
    while($row=$result->fetch_array()){
        // print_r("Allocated time=>   ".$row['from_time']."-". $row['to_time']);
        $time_set= '12:00-14:00';
        // $row['from_time']."-". $row['to_time'];

        // PARTITION THE TIME IN TERMS OF ONE HOUR
        $start = DateTime::createFromFormat('H:i', $row['from_time']);  //create date time objects
        $end = DateTime::createFromFormat('H:i', $row['to_time']);  //create date time objects
       
        for ($i = $start; $i < $end;)  //for loop 
        {
            $start_t = $i->format('H:i');   //take hour and minute
            $i->modify("+60 minutes");      //add 20 minutes
            $stop_t = $i->format('H:i');     //take hour and minute
            $time_set = $start_t . "-" . $stop_t;
            // print_r($time_set);
            array_push($booked, $time_set);

        }

    }
}
$start = DateTime::createFromFormat('H:i', $start_time);  //create date time objects
$end = DateTime::createFromFormat('H:i', $end_time);  //create date time objects
$count = 0;  //number of slots
$out = array();   //array of slots 
for ($i = $start; $i < $end;)  //for loop 
{
    $avoid = false;   //booked slot?
    $time1 = $i->format('H:i');   //take hour and minute
    $i->modify("+60 minutes");      //add 20 minutes
    $time2 = $i->format('H:i');     //take hour and minute
    $slot = $time1 . "-" . $time2;      //create a format 12:40-13:00 etc
    for ($k = 0; $k < sizeof($booked); $k++)  //if booked hour
    {
        if ($booked[$k] == $slot)  //check
            $avoid = true;   //yes. booked

    
    }
    if (!$avoid && $i < $end)  //if not booked and less than end time
    {
        $count++;           //add count
        $slots = $time1 . "-" . $time2;
        echo "\n";         //add count
        array_push($out, $slots); //add slot to array
    }
}


// echo '<pre>';
// print_r($out);
// echo '</pre>';
// echo $count . " of slots available";

// $m=0;
// echo "Free Time slots";
// while($m<$count){


    
//      echo '<ul><li>';
//       echo "while working ".$out[$m];
//       echo '</li></ul>';
//     $m++;
// }

// foreach ($results[$out] as $result) {


// }

?>
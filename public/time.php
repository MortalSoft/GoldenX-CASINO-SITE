<?php
$date = "01.01.2022 00:00:00 MSK"; // Исходная дата
$date_sec = strtotime($date);
echo $date_sec;
echo '<br>';

$time =  time();
echo $time;

echo '<br>';
echo $date_sec - $time;
?> 
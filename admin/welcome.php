<?php
     require_once '../load.php';

     $time = time();
     date_default_timezone_set('America/Toronto');
     $now = date("H");
 
     if ($now < "12") {
     echo "Hey you, good morning! Have you had a good breakfast today?";
     } 
 
     elseif ($now >= "12" && $now < "18") {
     echo "Good afternoon, you sweet sunflower. Hope your day is going well!";
    } 
     
     elseif ($now >= "18") {
     echo "Good evening, friend. Time to kick your feet up!";
     } 
 
 $inOneMonth = 60 * 60 * 24 * 30 + $time;
 setcookie('lastLogin', date("g:i - m/d/y"), $inOneMonth);
 if(isset($_COOKIE['lastLogin']))
 
 {
 
 $visit = $_COOKIE['lastLogin'];
 echo "Your last visit was ". $visit;
 }
 
 
 else
 echo "Haven't seen you in a while, welcome back!";



 ?>
 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome</h2>
</body>
</html>
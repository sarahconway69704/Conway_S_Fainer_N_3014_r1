<?php
 require_once '../load.php';
 $time = time();
 // set a time variable
 date_default_timezone_set('America/Toronto');
 // define which timezone we are using/in
 $now = date("H");
 // define the current hour

 if ($now < "12") {
 echo "Hey you, good morning! Have you had a good breakfast today?";
 } 
 //if they log in before 12pm, show good morning greeting

 elseif ($now >= "12" && $now < "18") {
 echo "Good afternoon, you sweet sunflower. Hope your day is going well!";
} 
 //if they log in after or on 12pm and before 6pm, show afternoon greeting

 elseif ($now >= "18") {
 echo "Good evening, friend. Time to kick your feet up!";
 } 
 //if they log in after or on 6pm, show evening greeting


// last successful login 
setcookie('lastLogin', date("g:i - m/d/y"));
// use cookie to store user data of date and time of last login

if(isset($_COOKIE['lastLogin'])){
//if that cookie is set, show date and time

 $showdatetime = $_COOKIE['lastLogin'];
 echo " Your last visit was ". $showdatetime;

}


else{
 echo "Haven't seen you in a while, welcome back!"; }

?>
 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/main.css">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome</h2>
</body>
</html>
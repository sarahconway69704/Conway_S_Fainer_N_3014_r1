<?php
    require_once 'load.php';

    // start a session once page loads

    session_start();

    $ip = $_SERVER['REMOTE_ADDR'];




    

    if(isset($_POST['submit'])){

        // take username and pw
        
        $username = trim($_POST['username']);
        $password = trim($_POST['password']); 

        

        
        
        if(!empty($username) && !empty($password)){
            // if the user entered a username and password
            
            
            //attempt to log user in

            

            $message = login($username, $password, $ip);


            
           
        } 

        
        

    }



    
    echo 'Number of login attempts: '.$_SESSION['login-attempts'];
    // echo $_SESSION['logged-in'];

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Login Page</title>
</head>
<body>
    <h2>Login Page</h2>

    <?php echo !empty($message)? $message: ''; ?>
    <form action="index.php" method="post">

        <input type="text" name="username" id="username" value="" placeholder="Username">


        <input type="password" name="password" id="password" value="" placeholder="Password">

        <button name="submit" type="submit">Login</button>

        
    </form>
</body>
</html>



<?php

// set session variable defaults

$_SESSION['login-attempts'] = 0;

// 0 means not locked out and 1 means locked out
$_SESSION['attempted-login'] = 0;


function login($username, $password, $ip){

    $_SESSION['login-attempts'] += 1;
    
    // establish a database connection

    $pdo = Database::getInstance()->getConnection();
    //Check existence
    $check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name= :username';
    $user_set = $pdo->prepare($check_exist_query);
    $user_set->execute(
        array(
            ':username' => $username,
        )
    );


// first check to see if the user is locked out
// if the user is (set to 1) then enter this if statement

    if ($_SESSION['attempted-login'] == 1) {


        $message = 'maximum log in attempts reached, please wait 30 seconds';
              
            // get the current time and take the number of seconds
              $now =  substr(date("Y-m-d H:i:s"),-2);

              // if the number of seconds since the functoin was called is greater than 30, unlockout the user
              // and give them another 3 attempts

              if ($now >= 30){

                  $_SESSION['login-attempts'] = 0;
                  $_SESSION['attempted-login'] = 0;
              } 

        // if the user is not locked out, check to see how many login attempts they took
        // if they tried to log in 3 times, then reset the attempts variable and lock the user out    

    } elseif ($_SESSION['login-attempts'] > 2) {
        // lock the user out 

        $_SESSION['attempted-login'] = 1;
        $_SESSION['login-attempts'] = 0;
        
        $message = 'maximum log in attempts reached, please wait 30 seconds';


    } else {

// if the user isnt locked out and has not reached 3 attempts, then check their credentials to see if 
// the username and pw is valid 


        if($user_set->fetchColumn()>0){
        
            //User exists
            $get_user_query = 'SELECT * FROM tbl_user WHERE user_name = :username';
            $get_user_query .= ' AND user_pass = :password';
            $user_check = $pdo->prepare($get_user_query);
            $user_check->execute(
                array(
                    ':username'=>$username,
                    ':password'=>$password
                )
                );
    
          while($found_user = $user_check->fetch(PDO::FETCH_ASSOC)){
              $id = $found_user['user_id'];
              //Logged In!
              $message = 'You logged in';
    
              
              $update_query = 'UPDATE tbl_user SET user_ip = :ip WHERE user_id = :id';
              $update_set = $pdo->prepare($update_query);
              $update_set->execute(
                  array(
                      ':ip'=>$ip,
                      ':id'=>$id
                  )
              );
          }

    
          if(isset($id)){

            // record last successful login into the database
            $tm = date("Y-m-d H:i:s");
            $update_query = 'UPDATE tbl_user SET user_timestamp = :tm WHERE user_id = :id';
            $update_set = $pdo->prepare($update_query);
            $update_set->execute(
                array(
                    ':id'=>$id,
                    ':tm'=> $tm
                )
            );

            //once logged in, reset all the session variables

            $_SESSION['login-attempts'] = 0;
            $_SESSION['attempted-login'] = 0;
            redirect_to('admin/welcome.php');      
          } 
    
            //user login
    
            
        } else {
        
        //user does not exist
        $message = 'user does not exist';

        }
    }

    //log user in

    return $message; 
    


}

?>
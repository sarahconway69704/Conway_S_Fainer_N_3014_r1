<?php

$_SESSION['login-attempts'] = 0;
$_SESSION['attempted-login'] = 0;


function login($username, $password, $ip){

    $_SESSION['login-attempts'] += 1;
    

    $pdo = Database::getInstance()->getConnection();
    //Check existence
    $check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name= :username';
    $user_set = $pdo->prepare($check_exist_query);
    $user_set->execute(
        array(
            ':username' => $username,
        )
    );




    if ($_SESSION['attempted-login'] == 1) {


        $message = 'maximum log in attempts reached, please wait 30 seconds';
              

              $now =  substr(date("Y-m-d H:i:s"),-2);

              if ($now >= 30){

                  $_SESSION['login-attempts'] = 0;
                  $_SESSION['attempted-login'] = 0;
              } 


    } elseif ($_SESSION['login-attempts'] > 2) {
        // lock the user out 

        $_SESSION['attempted-login'] = 1;
        $_SESSION['login-attempts'] = 0;
        
        $message = 'maximum log in attempts reached, please wait 30 seconds';


    } else {


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
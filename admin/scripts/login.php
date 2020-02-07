<?php

function login($username, $password, $ip){

    $pdo = Database::getInstance()->getConnection();
    //Check existence
    $check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name= :username';
    $user_set = $pdo->prepare($check_exist_query);
    $user_set->execute(
        array(
            ':username' => $username,
        )
    );

    if ($_SESSION['login-attempts'] == 3) {

        $_SESSION['logged-in'] = 0;

        // lock the user out
    
    } elseif ($_SESSION['logged-in'] == 0) {

        // if the user is locked out

                $now = time();
        if ($now >= 30) {
            unset($_SESSION['login-attempts']);
            unset($_SESSION['logged-in']);
        } else {
            $message = 'please wait 30 seconds';
        }


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
              redirect_to('admin/welcome.php');
              $_SESSION['logged-in'] = 1;
          } 
    
            //user login
    
            
        } else {
        
        //user does not exist
        $message = 'user does not exist';

        $_SESSION['login-attempts'] += 1;

        }
    }


    //log user in

    return $message; 
    


}

?>
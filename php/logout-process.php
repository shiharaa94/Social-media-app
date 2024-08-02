<?php 

require ('../config/db-config.php');

// get logged user id
$user_id = $_COOKIE['logged_user'];

// update logout details
$login_status = 0;
$userSessionStatusUpdate = "UPDATE users SET login_status=? WHERE id=?";
$updateLogout = $db_con->prepare($userSessionStatusUpdate);
$updateLogout->bind_param('ss',$login_status,$user_id);

    if($updateLogout->execute() === true){

        // Clear cookies when logging out
        $cookie_user_id = "logged_user";
        setcookie($cookie_user_id, "", time() - 3600, "/");

        $cookie_user_name = "logged_username";
        setcookie($cookie_user_name, "", time() - 3600, "/");

        $cookie_user_profilepic = "logged_profilePic";
        setcookie($cookie_user_profilepic, "", time() - 3600, "/");

        
        unset($_COOKIE[$cookie_user_id]);
        unset($_COOKIE[$cookie_user_name]);
        unset($_COOKIE[$cookie_user_profilepic]);
        session_destroy();
        header('location:../');
       
    }
?>
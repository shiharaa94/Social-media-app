<?php 

require ('../config/db-config.php');

//data get from front end
    $email = mysqli_real_escape_string($db_con, $_POST['email']);
    $password = mysqli_real_escape_string($db_con, $_POST['password']);

    // check email availability
    $sql_check_email = $db_con->prepare('SELECT * FROM users WHERE email=?');
    $sql_check_email->bind_param('s',$email);
    $sql_check_email->execute();
    $check_email_result = $sql_check_email->get_result();

    if($check_email_result->num_rows >0){
        // password check
        $selected_user_data = $check_email_result-> fetch_assoc();
        $userDB_id = $selected_user_data['id'];
        $userDB_password = $selected_user_data['password'];
        $userDB_username = $selected_user_data['username'];
        $userDB_profilePic = $selected_user_data['profile_pic'];

        $password = mysqli_real_escape_string($db_con, $_POST['password']);
        $pwd_verify = password_verify($password,$userDB_password);
        
        if ($pwd_verify == true){
            // password matched
            $login_status = 1;
            $userSessionStatusUpdate = "UPDATE users SET login_status=? WHERE id=?";
            $updateLogin = $db_con->prepare($userSessionStatusUpdate);
            $updateLogin->bind_param('ss',$login_status,$userDB_id);

            if($updateLogin->execute() === true){

                // set cookie for store logged user
                $cookie_user_id = "logged_user";
                $cookie_user_id_value = $userDB_id;
                setcookie($cookie_user_id, $cookie_user_id_value, time() + (86400), "/");

                 $cookie_user_name = "logged_username";
                 $cookie_username_value = $userDB_username;
                 setcookie($cookie_user_name, $cookie_username_value, time() + (86400), "/");

                 $cookie_user_profilepic = "logged_profilePic";
                 $cookie_profilepic_value = $userDB_profilePic;
                 setcookie($cookie_user_profilepic, $cookie_profilepic_value, time() + (86400), "/");

                // send success json status
                echo json_encode(['status' => 200]);
                exit;
            }else{

            // send update error json status
            echo json_encode(['status' => 200]);
            exit;
            }
            
        }else{
            //password did not match
            echo json_encode(['status' => 201]);
            exit;
        }
        
    }else{
        // email did not match
        echo json_encode(['status' => 201]);
            exit;
    }

?>
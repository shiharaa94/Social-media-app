<?php 
require ('../config/db-config.php');

    $firstname = mysqli_real_escape_string($db_con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db_con, $_POST['lastname']);
    $gender = mysqli_real_escape_string($db_con, $_POST['gender']);
    $email = mysqli_real_escape_string($db_con, $_POST['email']);
    $username = mysqli_real_escape_string($db_con, $_POST['username']);
    $password = mysqli_real_escape_string($db_con, $_POST['password']);
    $password_enc = password_hash($password,PASSWORD_DEFAULT,['cost'=>12]);
    

    // check email if already exist
    $sql_check_email = $db_con->prepare('SELECT * FROM users WHERE email=?');
    $sql_check_email->bind_param('s',$email);
    $sql_check_email->execute();
    $check_email_result = $sql_check_email->get_result();

    if($check_email_result->num_rows >0){
        echo json_encode(['status' => 201]);
            exit;
    }else{

        // check username if already exist
        $sql_check_username = $db_con->prepare('SELECT * FROM users WHERE username=?');
        $sql_check_username->bind_param('s',$username);
        $sql_check_username->execute();
        $check_username_result = $sql_check_username->get_result();
            
        if($check_username_result->num_rows >0){

            echo json_encode(['status' => 202]);
                exit;
        }else{


            //...............
         
                // Check if file was uploaded without errors
                if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
                    $file = $_FILES['profile_pic'];
            
                    // Get file details
                    $fileName = $file['name'];
                    $fileTmpPath = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileType = $file['type'];
                    $fileError = $file['error'];
            
                    // Define allowed file extensions
                    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
            
                    // Extract file extension
                    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            
                    // Check if file extension is allowed
                    if (in_array(strtolower($fileExtension), $allowedFileTypes)) {
                        // Define the upload path
                        $uploadPath = '../img/Profilepic/';
                        // Create the upload directory if it doesn't exist
                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                        }
            
                        // Define the target file path
                        $targetFilePath = $uploadPath . basename($fileName);
            
                        // Move the uploaded file to the target directory
                        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                            

                            // save data to database with profile pic
                            $store_user = $db_con->prepare("INSERT INTO users (firstname,lastname,gender,email,username,profile_pic,password) VALUES (?,?,?,?,?,?,?)");
                            $store_user->bind_param('sssssss',$firstname,$lastname,$gender,$email,$username,$proPic,$password_enc);
                            
                            $firstname = $firstname;
                            $lastname = $lastname;
                            $gender = $gender;
                            $email = $email;
                            $username = $username;
                            $password_enc = $password_enc;
                            $proPic = $fileName;

                            if($store_user->execute() === TRUE){
                                echo json_encode(['status' => 200]);
                                exit;

                            } else{
                                echo json_encode(['status' => 203]);
                                exit;
                            }

                        } else {
                            echo "There was an error moving the uploaded file.";
                        }
                    } else {
                        echo "Invalid file type. Allowed types are: " . implode(', ', $allowedFileTypes);
                    }
                } else {

                    // save data to database
            $store_user = $db_con->prepare("INSERT INTO users (firstname,lastname,gender,email,username,password) VALUES (?,?,?,?,?,?)");
            $store_user->bind_param('ssssss',$firstname,$lastname,$gender,$email,$username,$password_enc);
            
            $firstname = $firstname;
            $lastname = $lastname;
            $gender = $gender;
            $email = $email;
            $username = $username;
            $password_enc = $password_enc;
           

            if($store_user->execute() === TRUE){
                echo json_encode(['status' => 200]);
                exit;

            } else{
                echo json_encode(['status' => 203]);
                exit;
            }
                }
           
            //................
            

           
        }
        
    }
;?>
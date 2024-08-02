<?php 
require ('../config/db-config.php');

$firstname = mysqli_real_escape_string($db_con, $_POST['edit_firstname']);
$lastname = mysqli_real_escape_string($db_con, $_POST['edit_lastname']);
$gender = mysqli_real_escape_string($db_con, $_POST['edit_gender']);
$email = mysqli_real_escape_string($db_con, $_POST['edit_email']);
$username = mysqli_real_escape_string($db_con, $_POST['edit_username']);
$logged_user = intval($_COOKIE['logged_user']); // Ensure it's an integer for use in SQL

// Check email if already exists
$sql_check_email = $db_con->prepare('SELECT * FROM users WHERE email=? AND id <> ?');
$sql_check_email->bind_param('si', $email, $logged_user);
$sql_check_email->execute();
$check_email_result = $sql_check_email->get_result();

if ($check_email_result->num_rows > 0) {
    echo json_encode(['status' => 201]);
    exit;
} else {
    // Check username if already exists
    $sql_check_username = $db_con->prepare('SELECT * FROM users WHERE username=? AND id <> ?');
    $sql_check_username->bind_param('si', $username, $logged_user);
    $sql_check_username->execute();
    $check_username_result = $sql_check_username->get_result();

    if ($check_username_result->num_rows > 0) {
        echo json_encode(['status' => 202]);
        exit;
    } else {
        // Handle profile picture upload
        $profile_pic_path = '';
        if (isset($_FILES['edit_profile_pic']) && $_FILES['edit_profile_pic']['error'] == 0) {
            $file = $_FILES['edit_profile_pic'];
            $fileName = $file['name'];
            $fileTmpPath = $file['tmp_name'];
            $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $allowedFileTypes)) {
                $uploadPath = '../img/Profilepic/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $targetFilePath = $uploadPath . basename($fileName);
                if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                    $profile_pic_path = $fileName;
                } else {
                    echo json_encode(['status' => 204, 'error' => 'Error moving the uploaded file.']);
                    exit;
                }
            } else {
                echo json_encode(['status' => 205, 'error' => 'Invalid file type. Allowed types are: ' . implode(', ', $allowedFileTypes)]);
                exit;
            }
        }

        // Save data to database
        if ($profile_pic_path) {
            $sql_update = $db_con->prepare("UPDATE users SET firstname = ?, lastname = ?, gender = ?, email = ?, username = ?, profile_pic = ? WHERE id = ?");
            $sql_update->bind_param('ssssssi', $firstname, $lastname, $gender, $email, $username, $profile_pic_path, $logged_user);
        } else {
            $sql_update = $db_con->prepare("UPDATE users SET firstname = ?, lastname = ?, gender = ?, email = ?, username = ? WHERE id = ?");
            $sql_update->bind_param('sssssi', $firstname, $lastname, $gender, $email, $username, $logged_user);
        }

        if ($sql_update->execute() === TRUE) {
            echo json_encode(['status' => 200]);
            exit;
        } else {
            echo json_encode(['status' => 203]);
            exit;
        }
    }
}
?>

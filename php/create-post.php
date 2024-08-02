<?php 

require ('../config/db-config.php');

//data get from front end
$description = mysqli_real_escape_string($db_con, $_POST['description']);

// Assume $logged_user coming from a trusted source or sanitized
$logged_user = isset($_COOKIE['logged_user']) ? intval($_COOKIE['logged_user']) : 0;

// Check if $logged_user is valid
if ($logged_user <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user']);
    exit;
}

// Check if file was uploaded without errors
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $file = $_FILES['file'];

    // Get file details
    $fileName = $file['name'];
    $fileTmpPath = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileType = $file['type'];

    // Define allowed file extensions
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];

    // Extract file extension
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    // Check if file extension is allowed
    if (in_array(strtolower($fileExtension), $allowedFileTypes)) {
        // Define the upload path
        $uploadPath = '../img/post_images/';
        // Create the upload directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Define the target file path
        $NewFileName = $logged_user . "_" . time() . "." . $fileExtension;  // Corrected file naming
        $targetFilePath = $uploadPath . basename($NewFileName);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            
            // Prepare the SQL query using prepared statements
            $createPost = $db_con->prepare("INSERT INTO posts (description, post_image, user_id) VALUES (?, ?, ?)");
            $createPost->bind_param('ssi', $description, $NewFileName, $logged_user);

            if($createPost->execute()) {
                echo json_encode(['status' => 200]);
            } else {
                echo json_encode(['status' => 201, 'error' => $createPost->error]);  // Added detailed error
            }
            $createPost->close();
            exit;

        } else {
            echo json_encode(['status' => 202, 'error' => 'File upload failed.']);
            exit;
        }
    } else {
        echo json_encode(['status' => 203, 'error' => 'Invalid file type.']);
        exit;
    }

} else {

    if(empty($_FILES['file']) && empty($description)){
        // nothing to do anything
    }else{
        // Create post without image
        $createPost = $db_con->prepare("INSERT INTO posts (description, user_id) VALUES (?, ?)");
        $createPost->bind_param('si', $description, $logged_user);

        if($createPost->execute()) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 201, 'error' => $createPost->error]);  // Added detailed error
        }
        $createPost->close();
        exit;
    }

    
}
?>

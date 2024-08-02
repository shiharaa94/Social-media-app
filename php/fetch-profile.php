<?php 

require ('../config/db-config.php');

// Ensure the 'logged_user' cookie is set and valid
if (!isset($_COOKIE['logged_user']) || !is_numeric($_COOKIE['logged_user'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user.']);
    exit;
}

$logged_user = (int) $_COOKIE['logged_user']; // Cast to int for security

// Prepare the SQL statement
$User_profile = $db_con->prepare("SELECT * FROM users WHERE id = ?");
if (!$User_profile) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to prepare statement.']);
    exit;
}

$User_profile->bind_param('i', $logged_user);
if (!$User_profile->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to execute statement.']);
    exit;
}

$result = $User_profile->get_result();
if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'User not found.']);
    exit;
}

// Fetch the user profile data
$profile_data = $result->fetch_assoc();

$User_profile->close();
$db_con->close();

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Encode the profile data as JSON
$json_response = json_encode($profile_data);
if ($json_response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to encode JSON.']);
    exit;
}

// Log the JSON response
error_log($json_response);

// Output the JSON response
echo $json_response;
?>

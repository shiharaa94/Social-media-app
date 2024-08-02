<?php 
require ('../config/db-config.php');

// Assume $logged_user coming from a trusted source or sanitized
$logged_user = isset($_COOKIE['logged_user']) ? intval($_COOKIE['logged_user']) : 0;

// Check if $logged_user is valid
if ($logged_user <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user']);
    exit;
}

// Prepare the SQL query using prepared statements
$stmt = $db_con->prepare("SELECT * FROM users WHERE id <> ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to prepare statement']);
    exit;
}
$stmt->bind_param('i', $logged_user);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to execute query']);
    exit;
}

$friends = [];
while ($row = $result->fetch_assoc()) {
    $friends[] = $row;
}

$stmt->close();
$db_con->close();

// Set the Content-Type header to application/json
header('Content-Type: application/json');

$json_response = json_encode($friends);
error_log($json_response); // Log the JSON response
echo $json_response;

?>

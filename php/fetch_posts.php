<?php 
require ('../config/db-config.php');

// Get the offset and limit from the request
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 2;

// Assume $logged_user coming from a trusted source or sanitized
$logged_user = isset($_COOKIE['logged_user']) ? intval($_COOKIE['logged_user']) : 0;

// Check if $logged_user is valid
if ($logged_user <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user']);
    exit;
}

// Prepare the SQL query using prepared statements
//$stmt = $db_con->prepare("SELECT * FROM user_posts WHERE user_id <> ? ORDER BY created_at ASC LIMIT ? OFFSET ?");
$stmt = $db_con->prepare("SELECT p.id AS post_id, p.description AS description,p.post_likes AS post_likes, 
p.post_image AS post_image, u.firstname AS firstname, 
u.lastname AS lastname, u.profile_pic AS profile_pic, p.created_at, CASE WHEN pl.user_id IS NOT NULL THEN 1 ELSE 0 END AS liked 
FROM posts p LEFT JOIN post_like pl ON p.id = pl.post_id AND pl.user_id = ? INNER JOIN users u ON p.user_id = u.id 
WHERE p.user_id != ? ORDER BY created_at DESC LIMIT ? OFFSET ?");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to prepare statement']);
    exit;
}
$stmt->bind_param('iiii', $logged_user,$logged_user, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to execute query']);
    exit;
}

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

$stmt->close();
$db_con->close();

// Set the Content-Type header to application/json
header('Content-Type: application/json');

$json_response = json_encode($posts);
error_log($json_response); // Log the JSON response
echo $json_response;

?>

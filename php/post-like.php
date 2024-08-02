<?php 
require('../config/db-config.php');

$post_id = $_POST['id'];
$user_id = $_COOKIE['logged_user'];

// Check if post already liked
$postLikeStatus = $db_con->prepare("SELECT * FROM post_like WHERE user_id = ? AND post_id = ?");
$postLikeStatus->bind_param('ii', $user_id, $post_id);

$postLikeStatus->execute();
$result = $postLikeStatus->get_result();

$post_likes = ['id' => $post_id]; // Include the post ID in the response

if ($result->num_rows > 0) {
    // Unlike post
   
     $UpdateUnlikeStatus = $db_con->prepare("DELETE FROM post_like WHERE post_id = ? and user_id = ?");
     $UpdateUnlikeStatus->bind_param('ii', $post_id, $user_id);
     if($UpdateUnlikeStatus->execute() === true){
        $updateLikeCount = $db_con->prepare("UPDATE posts SET post_likes = post_likes - 1 WHERE id = ?");
        $updateLikeCount->bind_param('i', $post_id);

        if ($updateLikeCount->execute() === true) {
            $newPostLikeCount = $db_con->prepare("SELECT post_likes FROM posts WHERE id = ?");
            $newPostLikeCount->bind_param('i', $post_id);
            $newPostLikeCount->execute();
            $likeResult = $newPostLikeCount->get_result();

            if ($likeResult->num_rows > 0) {
                $post_likes['liked'] = "no";
                $post_likes['post_likes'] = $likeResult->fetch_assoc()['post_likes'];
            }
        }
     }
     $UpdateUnlikeStatus->close();
    
} else {
    // Like post
    $UpdateLikeStatus = $db_con->prepare("INSERT INTO post_like (post_id, user_id) VALUES (?, ?)");
    $UpdateLikeStatus->bind_param('ii', $post_id, $user_id);

    if ($UpdateLikeStatus->execute() === true) {
        $updateLikeCount = $db_con->prepare("UPDATE posts SET post_likes = post_likes + 1 WHERE id = ?");
        $updateLikeCount->bind_param('i', $post_id);

        if ($updateLikeCount->execute() === true) {
            $newPostLikeCount = $db_con->prepare("SELECT post_likes FROM posts WHERE id = ?");
            $newPostLikeCount->bind_param('i', $post_id);
            $newPostLikeCount->execute();
            $likeResult = $newPostLikeCount->get_result();

            if ($likeResult->num_rows > 0) {
                $post_likes['liked'] = "yes";
                $post_likes['post_likes'] = $likeResult->fetch_assoc()['post_likes'];
            }
        }

        $updateLikeCount->close();
    }

    $UpdateLikeStatus->close();
}

$postLikeStatus->close();
$db_con->close();

// Set the Content-Type header to application/json
header('Content-Type: application/json');
echo json_encode($post_likes);
?>

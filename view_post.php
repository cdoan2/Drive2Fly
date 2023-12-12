<?php
require 'connect.php';
require 'authenticate.php'; 

$post_id = $_GET['id'] ?? null;

if (!$post_id) {
    header("Location: blog_index.php");
    exit;
}

$query = "SELECT * FROM blog_posts WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindValue(':id', $post_id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();

if (!$post) {
    header("Location: blog_index.php");
    exit;
}

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_content'])) {
    $comment_content = trim($_POST['comment_content']);

    if (!empty($comment_content)) {
        $insert_comment = "INSERT INTO comments (post_id, content) VALUES (?, ?)";
        $comment_stmt = $db->prepare($insert_comment);
        $comment_stmt->execute([$post_id, $comment_content]);
        
        // Refresh the page to show the new comment
        header("Location: view_post.php?id=" . $post_id);
        exit;
    }
}

// Fetch comments for the post
$comments_query = "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC";
$comments_stmt = $db->prepare($comments_query);
$comments_stmt->execute([$post_id]);
$comments = $comments_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title><?= htmlspecialchars($post['title']); ?></title>
</head>
<body>
<div class="container">
    <h1><?= htmlspecialchars($post['title']); ?></h1>
    <p>Posted on <?= date("F d, Y, g:i a", strtotime($post['timestamp'])); ?></p>
    <div class="post-content">
        <?= nl2br(htmlspecialchars($post['content'])); ?>
    </div>
    
    <h2>Comments</h2>
    <form method="post">
        <textarea name="comment_content" rows="4" cols="50" required></textarea>
        <button type="submit">Add Comment</button>
    </form>
    
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <p><?= htmlspecialchars($comment['content']); ?></p>
            <!-- Additional details like date and author can be included here -->
        </div>
    <?php endforeach; ?>
    
    <a href="blog_index.php">Back to Blog</a>
</div>
</body>
</html>

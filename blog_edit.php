<?php
require 'connect.php';
require 'authenticate.php';

$postID = $_GET['id'] ?? null;
if (!$postID) {
    header("Location: blog_index.php");
    exit;
}

$query = "SELECT * FROM blog_posts WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindValue(':id', $postID, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();

if (!$post) {
    echo "Post not found!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

    if (isset($_POST['update'])) {
        if (strlen($title) > 0 && strlen($content) > 0) {
            $update_query = "UPDATE blog_posts SET title = :title, content = :content WHERE id = :id";
            $update_statement = $db->prepare($update_query);
            $update_statement->bindValue(':title', $title);
            $update_statement->bindValue(':content', $content);
            $update_statement->bindValue(':id', $postID, PDO::PARAM_INT);
            $update_statement->execute();

            header("Location: blog_index.php");
            exit;
        } else {
            $errorMessage = "Both title and content must be at least 1 character in length.";
        }
    } elseif (isset($_POST['delete'])) {
        $delete_query = "DELETE FROM blog_posts WHERE id = :id";
        $delete_statement = $db->prepare($delete_query);
        $delete_statement->bindValue(':id', $postID, PDO::PARAM_INT);
        $delete_statement->execute();

        header("Location: blog_index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Blog Post</h1>

    <?php if(isset($errorMessage)): ?>
        <p class="error"><?= $errorMessage; ?></p>
    <?php endif; ?>
    
    <form action="blog_edit.php?id=<?= $postID; ?>" method="post">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']); ?>">
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="10" cols="30"><?= htmlspecialchars($post['content']); ?></textarea>
        </div>
        <div>
            <button type="submit" name="update">Update</button>
            <button type="submit" name="delete" value="1">Delete</button>
        </div>
    </form>
</body>
</html>

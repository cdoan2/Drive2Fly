<?php
require 'connect.php';
require 'authenticate.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

    if (strlen($title) > 0 && strlen($content) > 0) {
        $query = "INSERT INTO blog_posts (title, content) VALUES (:title, :content)";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->execute();

        header("Location: blog_index.php");
        exit;
    } else {
        $errorMessage = "Both title and content must be at least 1 character in length.";
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
    <title>Create New Post</title>
</head>
<body>
    <h1>Create a New Blog Post</h1>

    <?php if (isset($errorMessage)): ?>
        <p class="error"><?= $errorMessage; ?></p>
    <?php endif; ?>

    <form action="post.php" method="post">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title">
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="10" cols="30"></textarea>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>

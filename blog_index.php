<?php
require 'connect.php';
require 'authenticate.php'; 

// Fetch the five most recent blog posts
$query = "SELECT * FROM blog_posts ORDER BY timestamp DESC LIMIT 5";
$posts = $db->query($query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
    <title>Welcome to Drive2Fly Auto Rentals Blog!</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Drive2Fly Auto Rentals</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="list_vehicles.php">Vehicles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="specials.html">Special Offers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservations.php">Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Log in</a>
                </li>
                <!-- Additional nav items here -->
            </ul>
        </div>
    </nav>
<div class="container">
    <h1>Welcome to Drive2Fly Auto Rentals Blog!</h1>
    
    <div class="top-buttons">
        <a href="blog_index.php">Home</a>
        <a href="post.php">New Post</a>
    </div>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h2><a href="view_post.php?id=<?= $post['id']; ?>"><?= htmlspecialchars($post['title']); ?></a></h2>
            <p>Posted on <?= date("F d, Y, g:i a", strtotime($post['timestamp'])); ?></p>
            <p><?= htmlspecialchars(substr($post['content'], 0, 200)) . '...'; ?></p>
            <a href="view_post.php?id=<?= $post['id']; ?>">Read Full Post</a>
        </div>
    <?php endforeach; ?>
</div>
<!-- Footer -->
<footer class="bg-primary text-white text-center py-3">
        <p>&copy; 2023 Drive2Fly Auto Rentals</p>
    </footer>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

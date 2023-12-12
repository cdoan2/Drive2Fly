<?php
require 'connect.php'; 
$query = "SELECT * FROM vehicles"; 
$vehicles = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive2Fly Auto Rentals</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
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

    <!-- Hero Section -->
    <header class="jumbotron">
        <div class="container">
            <h1 class="display-4">Welcome to Drive2Fly Auto Rentals</h1>
            <p class="lead">We offer the best selection of rental vehicles at competitive rates.</p>
        </div>
    </header>

    <!-- Main Content -->
    <main role="main" class="container">
        <!-- Vehicle Listing Section -->
        <!-- Vehicle Listing Section -->
        <section class="my-5">
            <h2>Latest Vehicles</h2>
            <div class="row">
                <?php foreach ($vehicles as $vehicle): ?>
                    <div class="col-md-4">
                        <div class="card">
                        <img src="<?= 'uploads/' . htmlspecialchars(basename($vehicle['ImagePath'])) ?>" alt="Vehicle Image" style="width: 350px; height: 190px;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($vehicle['Make'] . ' ' . $vehicle['Model']); ?></h5>
                                <p class="card-text">
                                    Year: <?= htmlspecialchars($vehicle['Year']); ?><br>
                                    Status: <?= htmlspecialchars($vehicle['Status']); ?>
                                </p>
                                <a href="vehicle_details.php?id=<?= $vehicle['Vehicle_ID']; ?>" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        
    </main>

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

<?php
require 'connect.php'; // Ensure this file contains the correct PDO connection code

$vehicle_id = $_GET['id'] ?? null;

if (!$vehicle_id) {
    echo "Vehicle not found.";
    exit;
}

$query = "SELECT * FROM vehicles WHERE Vehicle_ID = :vehicle_id";
$statement = $db->prepare($query);
$statement->bindValue(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
$statement->execute();
$vehicle = $statement->fetch(PDO::FETCH_ASSOC);

if (!$vehicle) {
    echo "Vehicle not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($vehicle['Make'] . ' ' . $vehicle['Model']); ?> Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
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

    <div class="container mt-4">
        <h1><?= htmlspecialchars($vehicle['Make'] . ' ' . $vehicle['Model']); ?></h1>
        <img src="<?= 'uploads/' . htmlspecialchars(basename($vehicle['ImagePath'])) ?>" alt="Vehicle Image" style="width: 350px; height: 190px;">
        <p>Make: <?= htmlspecialchars($vehicle['Make']); ?></p>
        <p>Model: <?= htmlspecialchars($vehicle['Model']); ?></p>
        <p>Year: <?= htmlspecialchars($vehicle['Year']); ?></p>
        <p>Status: <?= htmlspecialchars($vehicle['Status']); ?></p>
        <!-- Add more vehicle details as needed -->
        
        <a href="reservations.php" class="btn btn-primary">Reserve This Vehicle</a>
    </div>

   
    
    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

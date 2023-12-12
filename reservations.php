<?php
require 'authenticate.php'; 
require 'connect.php'; 

// Fetch vehicle names from the database
try {
    $query = "SELECT Vehicle_ID, CONCAT(Make, ' ', Model) AS VehicleName FROM Vehicles ORDER BY Make, Model";
    $statement = $db->prepare($query);
    $statement->execute();
    $vehicles = $statement->fetchAll();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
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

    <!-- Reservations Section -->
    <main role="main" class="container">
        <h1>Reservations</h1>
        <p>Reserve your vehicle today! Use our easy online reservation system to book the vehicle of your choice.</p>
        <form action="reservation_process.php" method="post">
        <div class="form-group">
            <label for="vehicle_name">Vehicle Name:</label>
            <select class="form-control" id="vehicle_name" name="vehicle_name">
                    <?php foreach ($vehicles as $vehicle): ?>
                        <option value="<?= htmlspecialchars($vehicle['Vehicle_ID']) ?>">
                            <?= htmlspecialchars($vehicle['VehicleName']) ?>
                        </option>
                    <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="pickup_date">Pick-up Date:</label>
            <input type="date" class="form-control" id="pickup_date" name="pickup_date" required>
        </div>
        <div class="form-group">
            <label for="dropoff_date">Drop-off Date:</label>
            <input type="date" class="form-control" id="dropoff_date" name="dropoff_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Reserve</button>
    </form>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3">
        <p>&copy; 2023 Drive2Fly Auto Rentals</p>
    </footer>
</body>
</html>

<?php
require 'authenticate.php'; 
require 'connect.php'; 

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'Make'; // Default sort by 'Make'
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Define allowed sort columns to prevent SQL injection
$allowedSorts = ['Make', 'Model', 'Year', 'Status'];
$sort = in_array($sort, $allowedSorts) ? $sort : 'Make';

// The query to include search functionality
$searchQuery = $search ? "WHERE Make LIKE :search OR Model LIKE :search OR Status LIKE :search" : "";
$query = "SELECT * FROM Vehicles $searchQuery ORDER BY " . $sort;

try {
    $statement = $db->prepare($query);

    // Bind search parameter if there's a search query
    if ($search) {
        $searchParam = "%" . $search . "%";
        $statement->bindParam(':search', $searchParam, PDO::PARAM_STR);
    }

    $statement->execute();
    $vehicles = $statement->fetchAll();
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
    die($error);
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

    <h1>List of Vehicles</h1>
    <?php if (isset($error)): ?>
        <p><?= $error ?></p>
    <?php endif; ?>
    
    <!-- Search Form -->
    <form action="list_vehicles.php" method="get">
        <input type="text" name="search" placeholder="Search by Make, Model, or Status" value="<?= htmlspecialchars($search) ?>" style="width: 300px;">
        <input type="submit" value="Search">
    </form>

    <div>
        Sort by: 
        <a href="?sort=Make">Make</a> |
        <a href="?sort=Model">Model</a> |
        <a href="?sort=Year">Year</a> |
        <a href="?sort=Status">Status</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Status</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td><?= htmlspecialchars($vehicle['Make']) ?></td>
                    <td><?= htmlspecialchars($vehicle['Model']) ?></td>
                    <td><?= htmlspecialchars($vehicle['Year']) ?></td>
                    <td><?= htmlspecialchars($vehicle['Status']) ?></td>
                    <td>
                        <img src="<?= 'uploads/' . htmlspecialchars(basename($vehicle['ImagePath'])) ?>" alt="Vehicle Image" style="width: 100px; height: auto;">
                    </td>
                    <td>
                        <a href="edit_vehicle.php?id=<?= $vehicle['Vehicle_ID'] ?>">Edit</a> |
                        <a href="delete_vehicle.php?id=<?= $vehicle['Vehicle_ID'] ?>" onclick="return confirm('Are you sure you want to delete this vehicle?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="add_vehicle.html">Add New Vehicle</a>
    <a href="index.html">Home Page</a>

    
</body>
</html>

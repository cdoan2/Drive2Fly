<?php
require 'authenticate.php';
require 'connect.php';

$error = '';
$success = '';
$vehicle = null;

// Check if the vehicle ID is provided and valid
if (!isset($_GET['id']) || !($vehicleID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))) {
    header("Location: list_vehicles.php");
    exit;
}

// Fetch the vehicle details
try {
    $query = "SELECT * FROM Vehicles WHERE Vehicle_ID = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $vehicleID, PDO::PARAM_INT);
    $statement->execute();
    $vehicle = $statement->fetch();

    if (!$vehicle) {
        header("Location: list_vehicles.php");
        exit;
    }
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
    die($error);
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $make = filter_input(INPUT_POST, 'make', FILTER_SANITIZE_STRING);
    $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
    $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    // Validate the file upload
    if (isset($_FILES["vehicle_image"]) && $_FILES["vehicle_image"]["error"] === UPLOAD_ERR_OK) {
        // Include your file upload handling logic here
    }

    // Update the vehicle details in the database
    try {
        $query = "UPDATE Vehicles SET Make = :make, Model = :model, Year = :year, Status = :status WHERE Vehicle_ID = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':make', $make);
        $statement->bindValue(':model', $model);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':status', $status);
        $statement->bindValue(':id', $vehicleID);
        $statement->execute();

        // Handle the success scenario
        $success = "Vehicle updated successfully!";
        // Redirect to the list of vehicles page
        header('Location: list_vehicles.php?status=success&message=' . urlencode($success));
        exit;
    } catch (PDOException $e) {
        $error = "Error updating vehicle: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Vehicle</title>
</head>
<body>
    <h1>Edit Vehicle</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form action="edit_vehicle.php?id=<?= $vehicleID ?>" method="post" enctype="multipart/form-data">
        <div>
            <label for="make">Make:</label>
            <input type="text" id="make" name="make" value="<?= htmlspecialchars($vehicle['Make']) ?>" maxlength="15" required>
        </div>
        <div>
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" value="<?= htmlspecialchars($vehicle['Model']) ?>" maxlength="15" required>
        </div>
        <div>
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" value="<?= htmlspecialchars($vehicle['Year']) ?>" required>
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="available" <?= $vehicle['Status'] == 'available' ? 'selected' : '' ?>>Available</option>
                <option value="rented" <?= $vehicle['Status'] == 'rented' ? 'selected' : '' ?>>Rented</option>
                <option value="maintenance" <?= $vehicle['Status'] == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
            </select>
        </div>
        <div>
            <label for="vehicle_image">Vehicle Image:</label>
            <input type="file" id="vehicle_image" name="vehicle_image">
            <?php if ($vehicle['ImagePath']): ?>
                <img src="<?= 'uploads/' . htmlspecialchars(basename($vehicle['ImagePath'])) ?>" alt="Vehicle Image" style="max-width: 200px;">
            <?php endif; ?>
        </div>
        <input type="submit" value="Update Vehicle">
    </form>

    <a href="list_vehicles.php">Back to Vehicle List</a>
</body>
</html>

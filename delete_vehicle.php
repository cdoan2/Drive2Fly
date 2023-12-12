<?php
require 'authenticate.php';
require 'connect.php';

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        // Delete the vehicle image file
        $query = "SELECT ImagePath FROM Vehicles WHERE Vehicle_ID = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $vehicle = $statement->fetch();

        if ($vehicle && file_exists($vehicle['ImagePath'])) {
            unlink($vehicle['ImagePath']);
        }

        // Delete the vehicle record from the database
        $query = "DELETE FROM Vehicles WHERE Vehicle_ID = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();

        header("Location: list_vehicles.php");
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        die($error);
    }
} else {
    header("Location: list_vehicles.php");
    exit;
}
?>

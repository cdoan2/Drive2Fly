<?php

require 'authenticate.php'; 
require 'connect.php'; 

$error = '';
$success = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $make = filter_input(INPUT_POST, 'make', FILTER_SANITIZE_STRING);
    $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
    $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    if (isset($_FILES["vehicle_image"]) && $_FILES["vehicle_image"]["error"] == 0) {
        $allowedTypes = ['jpeg', 'jpg', 'png', 'gif'];
        $fileType = strtolower(pathinfo($_FILES["vehicle_image"]["name"], PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedTypes)) {
            $filename = basename($_FILES['vehicle_image']['name']);
            $newname = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $filename;

            if (move_uploaded_file($_FILES['vehicle_image']['tmp_name'], $newname)) {
                $success = "Vehicle image uploaded successfully!";
                
                // Insert vehicle information into the database
                try {
                    $query = "INSERT INTO Vehicles (Make, Model, Year, Status, ImagePath) VALUES (:make, :model, :year, :status, :image_path)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':make', $make);
                    $statement->bindValue(':model', $model);
                    $statement->bindValue(':year', $year);
                    $statement->bindValue(':status', $status);
                    $statement->bindValue(':image_path', $newname);
                    $statement->execute();
                    $success .= " Vehicle information saved successfully!";
                } catch (PDOException $e) {
                    $error = "Error: " . $e->getMessage();
                }
            } else {
                $error = "A problem occurred when saving the vehicle image.";
            }
        } else {
            $error = "Invalid file type. Only JPG, JPEG, PNG, & GIF files are allowed.";
        }
    } else {
        $error = "No vehicle image was uploaded or there was an upload error.";
    }
}

// Redirect or inform the user after the action
if ($success) {
    echo $success;
    // Redirect to a success page or the list of vehicles
    header('Location: list_vehicles.php');
    // exit;
} else {
    echo $error;
    // Redirect to an error page or stay on the form page
    // header('Location: add_vehicle.html');
    // exit;
}
?>

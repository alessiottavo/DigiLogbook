<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

// Include necessary files for form handling
require './service/AircraftService.php';

$aircraftService = new AircraftService();
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_aircraft'])) {
    $make = $_POST['make'];
    $registration = $_POST['registration'];
    $highPerformance = isset($_POST['high_performance']) ? 1 : 0;
    $taildragger = isset($_POST['taildragger']) ? 1 : 0;
    $complex = isset($_POST['complex']) ? 1 : 0;
    $gearRetractable = isset($_POST['gear_retractable']) ? 1 : 0;

    try {
        // Add the aircraft using the service
        $success = $aircraftService->addAircraft($make, $registration, $highPerformance, $taildragger, $complex, $gearRetractable);

        if ($success) {
            $message = "Aircraft added successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Error adding aircraft.";
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Aircraft</title>
    <style>
        /* Simple styling for the form */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea, button {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }
        textarea {
            height: 100px;
        }
    </style>
</head>
<body>
    <h1>Add New Aircraft</h1>

    <?php if (!empty($message)) : ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="make">Make:</label>
        <input type="text" id="make" name="make" required>

        <label for="registration">Registration:</label>
        <input type="text" id="registration" name="registration" required>

        <label for="high_performance">High Performance:</label>
        <input type="checkbox" id="high_performance" name="high_performance">

        <label for="taildragger">Taildragger:</label>
        <input type="checkbox" id="taildragger" name="taildragger">

        <label for="complex">Complex:</label>
        <input type="checkbox" id="complex" name="complex">

        <label for="gear_retractable">Gear Retractable:</label>
        <input type="checkbox" id="gear_retractable" name="gear_retractable">

        <button type="submit" name="create_aircraft">Add Aircraft</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>

<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

// Include necessary files for form handling
require './service/EntryLogService.php';
require './repository/AircraftRepository.php';

$entryLogService = new EntryLogService();
$aircraftRepo = new AircraftRepository();
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_entry'])) {
    $pilotId = $_SESSION['pilot_id'];
    $aircraftId = $_POST['aircraft_id'];
    $departurePlace = $_POST['departure_place'];
    $departureTime = $_POST['departure_time'];
    $arrivalPlace = $_POST['arrival_place'];
    $arrivalTime = $_POST['arrival_time'];
    $multiEngine = isset($_POST['multi_engine']) ? 1 : 0;
    $totalTime = $_POST['total_time'];
    $takeoffs = $_POST['takeoffs'];
    $landings = $_POST['landings'];
    $pilotFunCommand = $_POST['pilot_fun_command'];
    $pilotFunCopilot = $_POST['pilot_fun_copilot'];
    $pilotFunDual = $_POST['pilot_fun_dual'];
    $pilotFunInstructor = $_POST['pilot_fun_instructor'];
    $remarks = $_POST['remarks'];
    
    $entry = new LogEntry(
        $pilotId,
        $aircraftId,
        $departurePlace,
        $departureTime,
        $arrivalPlace,
        $arrivalTime,
        $multiEngine,
        $totalTime,
        $takeoffs,
        $landings,
        $pilotFunCommand,
        $pilotFunCopilot,
        $pilotFunDual,
        $pilotFunInstructor,
        $remarks
    );

    // Add the log entry using the repository
    $success = $entryLogService->addLogEntry($entry);

    if ($success) {
        $message = "Log entry added successfully!";
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Error adding log entry.";
    }
}

// Fetch aircraft data
$aircraftList = $aircraftRepo->getAllAircraft();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Log Entry</title>
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
    <h1>Add New Log Entry</h1>

    <?php if (!empty($message)) : ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="aircraft_id">Aircraft:</label>
        <select id="aircraft_id" name="aircraft_id" required>
            <option value="">Select Aircraft</option>
            <?php foreach ($aircraftList as $aircraft): ?>
                <option value="<?php echo htmlspecialchars($aircraft['id']); ?>">
                    <?php echo htmlspecialchars($aircraft['make']) . ' - ' . htmlspecialchars($aircraft['registration']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="departure_place">Departure Place:</label>
        <input type="text" id="departure_place" name="departure_place" required>

        <label for="departure_time">Departure Time:</label>
        <input type="datetime-local" id="departure_time" name="departure_time" required>

        <label for="arrival_place">Arrival Place:</label>
        <input type="text" id="arrival_place" name="arrival_place" required>

        <label for="arrival_time">Arrival Time:</label>
        <input type="datetime-local" id="arrival_time" name="arrival_time" required>

        <label for="multi_engine">Multi-Engine:</label>
        <input type="checkbox" id="multi_engine" name="multi_engine">

        <label for="total_time">Total Time:</label>
        <input type="number" step="0.1" id="total_time" name="total_time" required>

        <label for="takeoffs">Takeoffs:</label>
        <input type="number" id="takeoffs" name="takeoffs" required>

        <label for="landings">Landings:</label>
        <input type="number" id="landings" name="landings" required>

        <label for="pilot_fun_command">Pilot Function Command:</label>
        <input type="number" id="pilot_fun_command" name="pilot_fun_command" required>

        <label for="pilot_fun_copilot">Pilot Function Copilot:</label>
        <input type="number" id="pilot_fun_copilot" name="pilot_fun_copilot" required>

        <label for="pilot_fun_dual">Pilot Function Dual:</label>
        <input type="number" id="pilot_fun_dual" name="pilot_fun_dual" required>

        <label for="pilot_fun_instructor">Pilot Function Instructor:</label>
        <input type="number" id="pilot_fun_instructor" name="pilot_fun_instructor" required>

        <label for="remarks">Remarks:</label>
        <textarea id="remarks" name="remarks"></textarea>

        <button type="submit" name="create_entry">Add Log Entry</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>

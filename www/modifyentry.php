<?php
session_start();

require './service/EntryLogService.php';

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

// Initialize EntryLogService
$entryLogService = new EntryLogService();
$logEntriesRepo = new LogEntriesRepository();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entryId = intval($_POST['id']);
    $pilotId = intval($_POST['pilotId']);
    $aircraftId = intval($_POST['aircraft_id']);
    $departurePlace = $_POST['departure_place'];
    $departureTime = $_POST['departure_time'];
    $arrivalPlace = $_POST['arrival_place'];
    $arrivalTime = $_POST['arrival_time'];
    $multiEngine = isset($_POST['multi_engine']) ? 1 : 0;
    $totalTime = intval($_POST['total_time']);
    $takeoffs = intval($_POST['takeoffs']);
    $landings = intval($_POST['landings']);
    $pilotFunCommand = intval($_POST['pilot_fun_command']);
    $pilotFunCopilot = intval($_POST['pilot_fun_copilot']);
    $pilotFunDual = intval($_POST['pilot_fun_dual']);
    $pilotFunInstructor = intval($_POST['pilot_fun_instructor']);
    $remarks = strval($_POST['remarks']);

    try {
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
        $remarks,
        $entryId
    );

        // Update entry
        $entryLogService->updateLogEntry($entry);
        $message = "Entry updated successfully!";
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Fetch the log entry to edit
$entryId = intval($_GET['entry_id']);
$entry = $logEntriesRepo->getEntryById($entryId);
if (!$entry) {
    die("Entry not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Log Entry</title>
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
    <h1>Modify Log Entry</h1>

    <?php if (!empty($message)) : ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($entry->getId()); ?>">

        <input type="hidden" name="pilotId" value="<?php echo htmlspecialchars($entry->getPilotId()); ?>">

        <label for="aircraft_id">Aircraft ID:</label>
        <input type="number" id="aircraft_id" name="aircraft_id" value="<?php echo htmlspecialchars($entry->getAircraftId()); ?>" required>

        <label for="departure_place">Departure Place:</label>
        <input type="text" id="departure_place" name="departure_place" value="<?php echo htmlspecialchars($entry->getDeparturePlace()); ?>" required>

        <label for="departure_time">Departure Time:</label>
        <input type="datetime-local" id="departure_time" name="departure_time" value="<?php echo htmlspecialchars($entry->getDepartureTime()); ?>" required>

        <label for="arrival_place">Arrival Place:</label>
        <input type="text" id="arrival_place" name="arrival_place" value="<?php echo htmlspecialchars($entry->getArrivalPlace()); ?>" required>

        <label for="arrival_time">Arrival Time:</label>
        <input type="datetime-local" id="arrival_time" name="arrival_time" value="<?php echo htmlspecialchars($entry->getArrivalTime()); ?>" required>

        <label for="multi_engine">Multi Engine:</label>
        <input type="checkbox" id="multi_engine" name="multi_engine" <?php echo $entry->isMultiEngine() ? 'checked' : ''; ?>>

        <label for="total_time">Total Time (Minutes):</label>
        <input type="number" id="total_time" name="total_time" value="<?php echo htmlspecialchars($entry->getTotalTime()); ?>" required>

        <label for="takeoffs">Takeoffs:</label>
        <input type="number" id="takeoffs" name="takeoffs" value="<?php echo htmlspecialchars($entry->getTakeoffs()); ?>" required>

        <label for="landings">Landings:</label>
        <input type="number" id="landings" name="landings" value="<?php echo htmlspecialchars($entry->getLandings()); ?>" required>

        <label for="pilot_fun_command">Command Time:</label>
        <input type="number" id="pilot_fun_command" name="pilot_fun_command" value="<?php echo htmlspecialchars($entry->getPilotFunCommand()); ?>" required>

        <label for="pilot_fun_copilot">Copilot Time:</label>
        <input type="number" id="pilot_fun_copilot" name="pilot_fun_copilot" value="<?php echo htmlspecialchars($entry->getPilotFunCopilot()); ?>" required>

        <label for="pilot_fun_dual">Dual Time:</label>
        <input type="number" id="pilot_fun_dual" name="pilot_fun_dual" value="<?php echo htmlspecialchars($entry->getPilotFunDual()); ?>" required>

        <label for="pilot_fun_instructor">Instructor Time:</label>
        <input type="number" id="pilot_fun_instructor" name="pilot_fun_instructor" value="<?php echo htmlspecialchars($entry->getPilotFunInstructor()); ?>" required>

        <label for="remarks">Remarks:</label>
        <textarea id="remarks" id="remarks" name="remarks" value="<?php echo htmlspecialchars($entry->getRemarks()); ?>"></textarea>

        <button type="submit">Update Entry</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>

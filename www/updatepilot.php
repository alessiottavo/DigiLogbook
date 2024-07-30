<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

// Include necessary files for handling the form
require './repository/PilotRepository.php';
require './service/EntryLogService.php';

$pilotRepo = new PilotRepository();
$entriesService = new EntryLogService();
$message = '';
$pilotId = $_SESSION['pilot_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        // Handle update form submission
        $pilotId = intval($_POST['id']);
        $name = $_POST['pilot_name'];
        $student = isset($_POST['student']) ? 1 : 0;
        $ppl = $_POST['ppl'] ? $_POST['ppl'] : null;
        $cpl = $_POST['cpl'] ? $_POST['cpl'] : null;
        $atpl = $_POST['atpl'] ? $_POST['atpl'] : null;
        $hp = isset($_POST['hp']) ? 1 : 0;
        $complex = isset($_POST['complex']) ? 1 : 0;
        $gear = isset($_POST['gear']) ? 1 : 0;
        $tail = isset($_POST['tail']) ? 1 : 0;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if ($pilotRepo->updatePilot($pilotId, $name, $student, $hp, $complex, $gear, $tail, $ppl, $cpl, $atpl, $password)) {
            $message = "Pilot updated successfully!";
        } else {
            $message = "Error updating pilot.";
        }
    } elseif (isset($_POST['delete'])) {
        $entriesService->deleteAllEntries($pilotId);
        $pilotRepo->deletePilot($pilotId);
        header('Location: index.php');
         exit();
    }
}

// Fetch current pilot details for pre-filling the form
$pilot = $pilotRepo->getPilot($pilotId);
if (!$pilot) {
    die("Pilot not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Pilot</title>
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
    <h1>Update Pilot</h1>

    <?php if (!empty($message)) : ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($pilot['id']); ?>">

        <label for="pilot_name">Name:</label>
        <input type="text" id="pilot_name" name="pilot_name" value="<?php echo htmlspecialchars($pilot['pilot_name']); ?>" required>

        <label for="student">Student:</label>
        <input type="checkbox" id="student" name="student" <?php echo $pilot['student'] ? 'checked' : ''; ?>>

        <label for="ppl">PPL (Date):</label>
        <input type="datetime-local" id="ppl" name="ppl" value="<?php echo htmlspecialchars($pilot['ppl']); ?>">

        <label for="cpl">CPL (Date):</label>
        <input type="datetime-local" id="cpl" name="cpl" value="<?php echo htmlspecialchars($pilot['cpl']); ?>">

        <label for="atpl">ATPL (Date):</label>
        <input type="datetime-local" id="atpl" name="atpl" value="<?php echo htmlspecialchars($pilot['atpl']); ?>">

        <label for="hp">High Performance:</label>
        <input type="checkbox" id="hp" name="hp" <?php echo $pilot['hp'] ? 'checked' : ''; ?>>

        <label for="complex">Complex:</label>
        <input type="checkbox" id="complex" name="complex" <?php echo $pilot['complex'] ? 'checked' : ''; ?>>

        <label for="gear">Gear Retractable:</label>
        <input type="checkbox" id="gear" name="gear" <?php echo $pilot['gear'] ? 'checked' : ''; ?>>

        <label for="tail">Taildragger:</label>
        <input type="checkbox" id="tail" name="tail" <?php echo $pilot['tail'] ? 'checked' : ''; ?>>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">

        <button type="submit" name="update">Update Pilot</button>
        <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this pilot?');" style="background-color: red; color: white;">Delete Pilot</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>

<?php
require './repository/PilotRepository.php';
require './repository/LogEntriesRepository.php';
require './repository/AircraftRepository.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$pilotId = $_SESSION['pilot_id'];
$pilotRepo = new PilotRepository();
$logEntriesRepo = new LogEntriesRepository();
$aircraftRepo = new AircraftRepository();

// Fetch pilot info
$pilot = $pilotRepo->getPilot($pilotId);

// Pagination setup
$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch log entries
$logEntries = $logEntriesRepo->getEntriesWithOffset($pilotId, $limit, $offset);
$totalEntries = $logEntriesRepo->getTotalEntries($pilotId);
$totalPages = ceil($totalEntries / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Add your CSS styling here */
    </style>
</head>
<body>
    <h1>Pilot Dashboard</h1>
    <section>
        <h2>Pilot Information</h2>
        <p>Name: <?php echo htmlspecialchars($pilot['pilot_name']); ?></p>
        <p>Student: <?php echo htmlspecialchars($pilot['student']); ?></p>
        <p>PPL: <?php echo htmlspecialchars($pilot['ppl']); ?></p>
        <p>CPL: <?php echo htmlspecialchars($pilot['cpl']); ?></p>
        <p>ATPL: <?php echo htmlspecialchars($pilot['atpl']); ?></p>
        <p>Taildragger: <?php echo htmlspecialchars($pilot['tail']); ?></p>
        <p>High Performance: <?php echo htmlspecialchars($pilot['hp']); ?></p>
        <p>Complex: <?php echo htmlspecialchars($pilot['complex']); ?></p>
        <p>Retractable Gear: <?php echo htmlspecialchars($pilot['gear']); ?></p>
        
        <!-- Logout Button -->
        <form method="POST" action="logout.php">
            <button type="submit">Logout</button>
        </form>
        <p><a href="addentry.php">Add Entry</a></p>
        <p><a href="addaircraft.php">Add Aircraft</a></p>
        <p><a href="updatepilot.php">Change Pilot Information</a></p>
    </section>

    <section>
        <h2>Logbook Entries</h2>
        <table>
            <thead>
                <tr>
                    <th>Aircraft</th>
                    <th>Departure Place</th>
                    <th>Departure Time</th>
                    <th>Arrival Place</th>
                    <th>Arrival Time</th>
                    <th>Multi Engine</th>
                    <th>Total Time</th>
                    <th>Takeoffs</th>
                    <th>Landings</th>
                    <th>Command</th>
                    <th>Copilot</th>
                    <th>Dual</th>
                    <th>Instructor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logEntries as $entry): ?>
                    <?php
                    $aircraft = $aircraftRepo->getAircraft($entry->getAircraftId());
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($aircraft['make']); ?></td>
                        <td><?php echo htmlspecialchars($entry->getDeparturePlace()); ?></td>
                        <td><?php echo htmlspecialchars($entry->getDepartureTime()); ?></td>
                        <td><?php echo htmlspecialchars($entry->getArrivalPlace()); ?></td>
                        <td><?php echo htmlspecialchars($entry->getArrivalTime()); ?></td>
                        <td><?php echo $entry->isMultiEngine() ? 'Yes' : 'No'; ?></td>
                        <td><?php echo htmlspecialchars($entry->getTotalTime()); ?></td>
                        <td><?php echo htmlspecialchars($entry->getTakeoffs()); ?></td>
                        <td><?php echo htmlspecialchars($entry->getLandings()); ?></td>
                        <td><?php echo htmlspecialchars($entry->getPilotFunCommand()); ?></td>
                        <td><?php echo htmlspecialchars($entry->getPilotFunCopilot()); ?></td>
                        <td><?php echo htmlspecialchars($entry->getPilotFunDual()); ?></td>
                        <td><?php echo htmlspecialchars($entry->getPilotFunInstructor()); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div>
            <p>Page: <?php echo $page; ?> of <?php echo $totalPages; ?></p>
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>

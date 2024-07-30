<?php
include './repository/PilotRepository.php';
include './repository/LogEntriesRepository.php';

$pilotId = 1; // Example, ideally obtained from session or request
$pilotRepo = new PilotRepository();
$logEntriesRepo = new LogEntriesRepository();

// Fetch pilot info
$pilot = $pilotRepo->getPilot($pilotId);

// Pagination setup
$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch log entries
$entries = $logEntriesRepo->getEntriesWithOffset($pilotId, $limit, $offset);
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
                    <th>Copilot</th>Dual
                    <th>Dual</th>
                    <th>Instructor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entries as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['aircraft_id']); ?></td>
                        <td><?php echo htmlspecialchars($entry['departure_place']); ?></td>
                        <td><?php echo htmlspecialchars($entry['departure_time']); ?></td>
                        <td><?php echo htmlspecialchars($entry['arrival_place']); ?></td>
                        <td><?php echo htmlspecialchars($entry['arrival_time']); ?></td>
                        <td><?php echo htmlspecialchars($entry['multi_engine']); ?></td>
                        <td><?php echo htmlspecialchars($entry['total_time']); ?></td>
                        <td><?php echo htmlspecialchars($entry['takeoffs']); ?></td>
                        <td><?php echo htmlspecialchars($entry['landings']); ?></td>
                        <td><?php echo htmlspecialchars($entry['pilot_fun_command']); ?></td>
                        <td><?php echo htmlspecialchars($entry['pilot_fun_copilot']); ?></td>
                        <td><?php echo htmlspecialchars($entry['pilot_fun_dual']); ?></td>
                        <td><?php echo htmlspecialchars($entry['pilot_fun_instructor']); ?></td>
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

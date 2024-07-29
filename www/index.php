<?php
// Fetch environment variables or use defaults
$host = getenv('MYSQL_HOST') ?: 'mysqldb'; // Service name in docker-compose.yml
$dbname = getenv('MYSQL_DATABASE') ?: 'digilog_db';
$user = getenv('MYSQL_USER') ?: 'digilog';
$password = getenv('MYSQL_PASSWORD') ?: 'digilog_db';

echo "Connecting to: $host:$dbname with user $user" . PHP_EOL;

try {
    // Create a new PDO instance
    $dsn = "mysql:host=$host;port=3306;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!<br>";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage()); // Exit if connection fails
}

try {
    // Execute a query
    $stmt = $pdo->query("SELECT * FROM pilot");
    
    // Fetch all rows
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($rows) {
        foreach ($rows as $row) {
            // Output pilot name securely
            echo htmlspecialchars($row['pilot_name']) . '<br>';
        }
    } else {
        echo "No data found.<br>";
    }
    
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}

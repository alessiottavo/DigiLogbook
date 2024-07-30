<?php
// Fetch environment variables or use defaults
$host = getenv('MYSQL_HOST') ?: 'mysqldb'; // Service name in docker-compose.yml
$dbname = getenv('MYSQL_DATABASE') ?: 'digilog_db';
$user = getenv('MYSQL_USER') ?: 'digilog';
$password = getenv('MYSQL_PASSWORD') ?: 'digilog_db';

$retryAttempts = 5; // Number of times to retry the connection
$retryDelay = 5;    // Delay in seconds between retries

$connected = false;
$attempt = 0;

while (!$connected && $attempt < $retryAttempts) {
    try {
        // Create a new PDO instance
        $dsn = "mysql:host=$host;port=3306;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully!";
        $connected = true;
    } catch (PDOException $e) {
        $attempt++;
        echo "Connection failed (attempt $attempt): " . $e->getMessage() . PHP_EOL;
        if ($attempt < $retryAttempts) {
            sleep($retryDelay);
        } else {
            die("All attempts to connect to the database have failed. Please check your configuration.");
        }
    }
}
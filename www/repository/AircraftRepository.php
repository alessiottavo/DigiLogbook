<?php

class AircraftRepository {

    private $pdo;
    private $host;
    private $dbname;
    private $user;
    private $password;
        // Constructor to initialize the PDO instance and set the properties
        public function __construct() {
            // Set properties using environment variables or default values
            $this->host = getenv('MYSQL_HOST') ?: 'mysqldb'; // Service name in docker-compose.yml
            $this->dbname = getenv('MYSQL_DATABASE') ?: 'digilog_db';
            $this->user = getenv('MYSQL_USER') ?: 'digilog';
            $this->password = getenv('MYSQL_PASSWORD') ?: 'digilog_db';
    
            try {
                $dsn = "mysql:host={$this->host};port=3306;dbname={$this->dbname};charset=utf8";
                $this->pdo = new PDO($dsn, $this->user, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

public function getAircraft($id) {
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM aircrafts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to get pilot: " . $e->getMessage();
        return false;
    }
}

public function getAllAircraft() {
    try {
        $stmt = $this->pdo->query("SELECT id, make, registration FROM aircrafts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to get aircraft: " . $e->getMessage();
        return [];
    }
}
}
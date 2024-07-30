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

public function addAircraft($make, $registration, $highPerformance, $taildragger, $complex, $gearRetractable) {
    try {
        $sql = "INSERT INTO aircrafts (make, registration, high_performance, taildragger, complex, gear_retractable)
                VALUES (:make, :registration, :high_performance, :taildragger, :complex, :gear_retractable)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':make', $make, PDO::PARAM_STR);
        $stmt->bindParam(':registration', $registration, PDO::PARAM_STR);
        $stmt->bindParam(':high_performance', $highPerformance, PDO::PARAM_BOOL);
        $stmt->bindParam(':taildragger', $taildragger, PDO::PARAM_BOOL);
        $stmt->bindParam(':complex', $complex, PDO::PARAM_BOOL);
        $stmt->bindParam(':gear_retractable', $gearRetractable, PDO::PARAM_BOOL);

        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Failed to add aircraft: " . $e->getMessage();
        return false;
    }
}

public function aircraftExists($registration) {
    try {
        $sql = "SELECT COUNT(*) FROM aircrafts WHERE registration = :registration";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':registration', $registration, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    } catch (PDOException $e) {
        echo "Failed to check if aircraft exists: " . $e->getMessage();
        return false;
    }
}
}
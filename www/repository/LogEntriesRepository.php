<?php
Class LogEntriesRepository {

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

    public function getEntriesWithOffset($pilotId, $limit, $offset) {
        try {
            // Prepare the SQL query with placeholders for pilot_id and fixed placeholders for LIMIT and OFFSET
            $stmt = $this->pdo->prepare("SELECT * FROM logentries WHERE pilot_id = :pilot_id LIMIT :limit OFFSET :offset");
            
            // Bind the pilot_id parameter securely
            $stmt->bindValue(':pilot_id', $pilotId, PDO::PARAM_INT);
    
            // Bind LIMIT and OFFSET parameters
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
    
            // Execute the statement
            $stmt->execute();
    
            // Fetch and return all results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Failed to get Log Entries: " . $e->getMessage();
            return false;
        }
    }

    public function getTotalEntries($pilotId) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM logentries WHERE pilot_id = :pilot_id");
            $stmt->bindValue(':pilot_id', $pilotId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['count']; // Ensure you return an integer
        } catch (PDOException $e) {
            echo "Failed to get Total Entries: " . $e->getMessage();
            return 0; // Return 0 or another default value on error
        }
    }
}
<?php
require './model/LogEntry.php';

class LogEntriesRepository {

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

    // Fetch all entries for a given pilot with pagination
    public function getEntriesWithOffset($pilotId, $limit, $offset) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM logentries WHERE pilot_id = :pilot_id LIMIT :limit OFFSET :offset");

            $stmt->bindValue(':pilot_id', $pilotId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

            $stmt->execute();

            // Fetch all results as LogEntry objects
            $logEntries = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $logEntries[] = $this->mapRowToLogEntry($row);
            }

            return $logEntries;
        } catch (PDOException $e) {
            echo "Failed to get log entries: " . $e->getMessage();
            return false;
        }
    }

    // Fetch total number of entries for a given pilot
    public function getTotalEntries($pilotId) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM logentries WHERE pilot_id = :pilot_id");
            $stmt->bindValue(':pilot_id', $pilotId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['count'];
        } catch (PDOException $e) {
            echo "Failed to get total entries: " . $e->getMessage();
            return 0;
        }
    }
    public function deleteAllEntries($pilotId){
        try {
            $stmt = $this->pdo->prepare("DELETE FROM logentries WHERE pilot_id = :pilot_id");
            $stmt->bindValue(':pilot_id', $pilotId, PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Failed to delete log entries: " . $e->getMessage();
            return false;
        }
    }
    
    public function addEntryFromLogEntry(LogEntry $logEntry) {
        try {
            $sql = "INSERT INTO logentries (
                pilot_id, aircraft_id, departure_place, departure_time, arrival_place, arrival_time, multi_engine, 
                total_time, takeoffs, landings, pilot_fun_command, pilot_fun_copilot, pilot_fun_dual, 
                pilot_fun_instructor, remarks
            ) VALUES (
                :pilot_id, :aircraft_id, :departure_place, :departure_time, :arrival_place, :arrival_time, :multi_engine, 
                :total_time, :takeoffs, :landings, :pilot_fun_command, :pilot_fun_copilot, :pilot_fun_dual, 
                :pilot_fun_instructor, :remarks
            )";
    
            $stmt = $this->pdo->prepare($sql);
    
            $stmt->bindValue(':pilot_id', $logEntry->getPilotId(), PDO::PARAM_INT);
            $stmt->bindValue(':aircraft_id', $logEntry->getAircraftId(), PDO::PARAM_INT);
            $stmt->bindValue(':departure_place', $logEntry->getDeparturePlace(), PDO::PARAM_STR);
            $stmt->bindValue(':departure_time', $logEntry->getDepartureTime(), PDO::PARAM_STR);
            $stmt->bindValue(':arrival_place', $logEntry->getArrivalPlace(), PDO::PARAM_STR);
            $stmt->bindValue(':arrival_time', $logEntry->getArrivalTime(), PDO::PARAM_STR);
            $stmt->bindValue(':multi_engine', $logEntry->isMultiEngine(), PDO::PARAM_BOOL);
            $stmt->bindValue(':total_time', $logEntry->getTotalTime(), PDO::PARAM_STR);
            $stmt->bindValue(':takeoffs', $logEntry->getTakeoffs(), PDO::PARAM_INT);
            $stmt->bindValue(':landings', $logEntry->getLandings(), PDO::PARAM_INT);
            $stmt->bindValue(':pilot_fun_command', $logEntry->getPilotFunCommand(), PDO::PARAM_INT);
            $stmt->bindValue(':pilot_fun_copilot', $logEntry->getPilotFunCopilot(), PDO::PARAM_INT);
            $stmt->bindValue(':pilot_fun_dual', $logEntry->getPilotFunDual(), PDO::PARAM_INT);
            $stmt->bindValue(':pilot_fun_instructor', $logEntry->getPilotFunInstructor(), PDO::PARAM_INT);
            $stmt->bindValue(':remarks', $logEntry->getRemarks(), PDO::PARAM_STR);
    
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            echo "Failed to add log entry: " . $e->getMessage();
            return false;
        }
    }
    

    // Add a new log entry
    public function addEntry($pilotId, $aircraftId, $departurePlace, $departureTime, $arrivalPlace, $arrivalTime, $multiEngine, $totalTime, $takeoffs, $landings, $pilotFunCommand, $pilotFunCopilot, $pilotFunDual, $pilotFunInstructor, $remarks) {
        try {
            $sql = "INSERT INTO logentries (
                pilot_id, aircraft_id, departure_place, departure_time, arrival_place, arrival_time, multi_engine, 
                total_time, takeoffs, landings, pilot_fun_command, pilot_fun_copilot, pilot_fun_dual, 
                pilot_fun_instructor, remarks
            ) VALUES (
                :pilot_id, :aircraft_id, :departure_place, :departure_time, :arrival_place, :arrival_time, :multi_engine, 
                :total_time, :takeoffs, :landings, :pilot_fun_command, :pilot_fun_copilot, :pilot_fun_dual, 
                :pilot_fun_instructor, :remarks
            )";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':pilot_id', $pilotId, PDO::PARAM_INT);
            $stmt->bindParam(':aircraft_id', $aircraftId, PDO::PARAM_INT);
            $stmt->bindParam(':departure_place', $departurePlace, PDO::PARAM_STR);
            $stmt->bindParam(':departure_time', $departureTime, PDO::PARAM_STR);
            $stmt->bindParam(':arrival_place', $arrivalPlace, PDO::PARAM_STR);
            $stmt->bindParam(':arrival_time', $arrivalTime, PDO::PARAM_STR);
            $stmt->bindParam(':multi_engine', $multiEngine, PDO::PARAM_BOOL);
            $stmt->bindParam(':total_time', $totalTime, PDO::PARAM_STR);
            $stmt->bindParam(':takeoffs', $takeoffs, PDO::PARAM_INT);
            $stmt->bindParam(':landings', $landings, PDO::PARAM_INT);
            $stmt->bindParam(':pilot_fun_command', $pilotFunCommand, PDO::PARAM_INT);
            $stmt->bindParam(':pilot_fun_copilot', $pilotFunCopilot, PDO::PARAM_INT);
            $stmt->bindParam(':pilot_fun_dual', $pilotFunDual, PDO::PARAM_INT);
            $stmt->bindParam(':pilot_fun_instructor', $pilotFunInstructor, PDO::PARAM_INT);
            $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Failed to add log entry: " . $e->getMessage();
            return false;
        }
    }

    // Helper method to map a database row to a LogEntry object
    private function mapRowToLogEntry($row) {
        return new LogEntry(
            $row['pilot_id'],
            $row['aircraft_id'],
            $row['departure_place'],
            $row['departure_time'],
            $row['arrival_place'],
            $row['arrival_time'],
            (bool)$row['multi_engine'],
            $row['total_time'],
            $row['takeoffs'],
            $row['landings'],
            $row['pilot_fun_command'],
            $row['pilot_fun_copilot'],
            $row['pilot_fun_dual'],
            $row['pilot_fun_instructor'],
            $row['remarks'],
            $row['id']
        );
    }
}
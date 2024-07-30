<?php
class PilotRepository {
    private $pdo;
    private $host;
    private $dbname;
    private $user;
    private $password;

    public function __construct() {
        $this->host = getenv('MYSQL_HOST') ?: 'mysqldb';
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

    // Get a pilot by ID
    public function getPilot($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM pilots WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Failed to get pilot: " . $e->getMessage();
            return false;
        }
    }

    public function getPilotByName($name) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM pilots WHERE pilot_name = ?");
            $stmt->execute([$name]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Failed to get pilot: " . $e->getMessage();
            return null;
        }
    }

    // Save a new pilot
    public function savePilot($name, $password, $student, $hp, $complex, $gear, $tail, $ppl = null, $cpl = null, $atpl = null) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $this->pdo->prepare("INSERT INTO pilots (pilot_name, password, student, ppl, cpl, atpl, hp, complex, gear, tail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $hashedPassword, $student, $ppl, $cpl, $atpl, $hp, $complex, $gear, $tail]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Failed to save pilot: " . $e->getMessage();
            return null;
        }
    }

    // Update pilot information
    public function updatePilot($id, $name, $student, $hp, $complex, $gear, $tail, $ppl = null, $cpl = null, $atpl = null, $password = null) {
        try {
            if ($password) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->pdo->prepare("UPDATE pilots SET pilot_name = ?, student = ?, ppl = ?, cpl = ?, atpl = ?, hp = ?, complex = ?, gear = ?, tail = ?, password = ? WHERE id = ?");
                $stmt->execute([$name, $student, $ppl, $cpl, $atpl, $hp, $complex, $gear, $tail, $hashedPassword, $id]);
            } else {
                $stmt = $this->pdo->prepare("UPDATE pilots SET pilot_name = ?, student = ?, ppl = ?, cpl = ?, atpl = ?, hp = ?, complex = ?, gear = ?, tail = ? WHERE id = ?");
                $stmt->execute([$name, $student, $ppl, $cpl, $atpl, $hp, $complex, $gear, $tail, $id]);
            }
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Failed to update pilot: " . $e->getMessage();
            return false;
        }
    }

    // Login pilot
    public function loginPilot($name, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM pilots WHERE pilot_name = ?");
            $stmt->execute([$name]);
            $pilot = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($pilot && password_verify($password, $pilot['password'])) {
                return $pilot;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Login failed: " . $e->getMessage();
            return false;
        }
    }

    // Delete a pilot by ID
    public function deletePilot($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM pilots WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Failed to delete pilot: " . $e->getMessage();
            return false;
        }
    }
}

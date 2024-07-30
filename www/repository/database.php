<?php
class UserDatabase {
    private $pdo;

    // Constructor to initialize the PDO instance
    public function __construct($host, $dbname, $username, $password) {
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Create a new user
    public function createUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);
            return $this->pdo->lastInsertId(); // Return the ID of the created user
        } catch (PDOException $e) {
            echo "User creation failed: " . $e->getMessage();
            return false;
        }
    }

    // Update a user's password
    public function updateUserPassword($username, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->execute([$hashedPassword, $username]);
            return $stmt->rowCount(); // Return the number of affected rows
        } catch (PDOException $e) {
            echo "Password update failed: " . $e->getMessage();
            return false;
        }
    }

    // Delete a user
    public function deleteUser($username) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE username = ?");
            $stmt->execute([$username]);
            return $stmt->rowCount(); // Return the number of affected rows
        } catch (PDOException $e) {
            echo "User deletion failed: " . $e->getMessage();
            return false;
        }
    }
}

<?php
require './repository/PilotRepository.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $pilotRepo = new PilotRepository();
        $pilot = $pilotRepo->loginPilot($username, $password);

        if ($pilot) {
            $_SESSION['pilot_id'] = $pilot['id']; // Store pilot ID in session
            $_SESSION['logged_in'] = true; // Set login status

            // Redirect to dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</body>
</html>
<?php
require './repository/PilotRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

        $student = isset($_POST['student']) ? 1 : 0;
        $hp = isset($_POST['hp']) ? 1 : 0;
        $complex = isset($_POST['complex']) ? 1 : 0;
        $gear = isset($_POST['gear']) ? 1 : 0;
        $tail = isset($_POST['tail']) ? 1 : 0;
        $ppl = $_POST['ppl'] ?: null;
        $cpl = $_POST['cpl'] ?: null;
        $atpl = $_POST['atpl'] ?: null;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (!empty($username) && !empty($password)) {
       $pilotRepo = new PilotRepository();
       $pilot = $pilotRepo->getPilotByName($username);
       if ($pilot == null) {
        $id = $pilotRepo->savePilot($username, $password, $student, $ppl, $cpl, $atpl, $hp, $complex, $gear, $tail);
       }
        if (!empty($id)) {
            echo "Registration Succesful! Now login :)";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="student">Are you a student?</label>
        <input type="checkbox" id="student" name="student"><br><br>
        
        <label for="ppl">PPL (Private Pilot License) Date:</label>
        <input type="date" id="ppl" name="ppl"><br><br>
        
        <label for="cpl">CPL (Commercial Pilot License) Date:</label>
        <input type="date" id="cpl" name="cpl"><br><br>
        
        <label for="atpl">ATPL (Airline Transport Pilot License) Date:</label>
        <input type="date" id="atpl" name="atpl"><br><br>
        
        <label for="hp">High Performance Endorsement:</label>
        <input type="checkbox" id="hp" name="hp"><br><br>
        
        <label for="complex">Complex Endorsement:</label>
        <input type="checkbox" id="complex" name="complex"><br><br>
        
        <label for="gear">Retractable Gear Endorsement:</label>
        <input type="checkbox" id="gear" name="gear"><br><br>
        
        <label for="tail">Tailwheel Endorsement:</label>
        <input type="checkbox" id="tail" name="tail"><br><br>
        
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="index.php">Login here</a>.</p>
</body>
</html>

<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Collect form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $userid = $_POST['userid'];
    $email = $_POST['email'];
    $country_code = $_POST['country-code'];
    $contact = $_POST['contact'];
    $password_plain = $_POST['password']; // Plain text password
    $confirm_password = $_POST['confirm-password']; // Confirm password

    // Check if passwords match
    if ($password_plain !== $confirm_password) {
        echo json_encode(['error' => 'Passwords do not match']);
        exit;
    }

    // Insert user into database
    $sql = "INSERT INTO users (fullname, userid, email, country_code, contact, password)
            VALUES ('$fullname', '$userid', '$email', '$country_code', '$contact', '$password_plain')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => 'User added successfully']);
    } else {
        echo json_encode(['error' => 'Error adding user: ' . $conn->error]);
    }
}
$conn->close();
?>

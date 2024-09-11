<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get feedback ID from the request
$feedback_id = isset($_POST['feedback_id']) ? intval($_POST['feedback_id']) : 0;

if ($feedback_id > 0) {
    // Check current highlighted status
    $sql = "SELECT highlighted FROM feedback WHERE id = $feedback_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentStatus = $row['highlighted'];
        // Toggle the highlighted status
        $newStatus = $currentStatus ? 0 : 1;
        $sql = "UPDATE feedback SET highlighted = $newStatus WHERE id = $feedback_id";
        if ($conn->query($sql) === TRUE) {
            echo $newStatus ? "highlighted" : "not_highlighted";
        } else {
            echo "error";
        }
    }
}

$conn->close();
?>

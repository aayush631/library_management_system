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
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchTerm = "%{$searchTerm}%";

$sql = "SELECT userid, fullname FROM users WHERE fullname LIKE ? OR userid LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $searchTerm, $searchTerm);

$response = [];

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $response = ['success' => true, 'users' => $users];
} else {
    $response = ['success' => false, 'message' => 'Error executing query: ' . $stmt->error];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>

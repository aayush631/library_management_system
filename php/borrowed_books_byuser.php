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

$current_date = date('Y-m-d');

// Fetch borrowed books details
$sql = "SELECT user_id, user_fullname, book_id, book_name, return_date, 
        DATEDIFF('$current_date', return_date) AS overdue_days 
        FROM issued_books";
$result = $conn->query($sql);

$borrowedBooks = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['fine'] = max(0, $row['overdue_days'] * 10);
        $borrowedBooks[] = $row;
    }
}

$conn->close();

echo json_encode(['success' => true, 'data' => $borrowedBooks]);
?>

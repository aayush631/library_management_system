<?php

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

$response = [
    'total_users' => 0,
    'total_books' => 0,
    'books_available' => 0
];

// Fetch total users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);
if ($result_users->num_rows > 0) {
    $row = $result_users->fetch_assoc();
    $response['total_users'] = $row['total_users'];
}

// Fetch total books
$sql_books = "SELECT COUNT(*) AS total_books FROM books";
$result_books = $conn->query($sql_books);
if ($result_books->num_rows > 0) {
    $row = $result_books->fetch_assoc();
    $response['total_books'] = $row['total_books'];
}

// Fetch books available (assuming you have a way to track borrowed books)
$sql_available_books = "SELECT COUNT(*) AS books_available FROM books WHERE status = 'available'";
$result_available_books = $conn->query($sql_available_books);
if ($result_available_books->num_rows > 0) {
    $row = $result_available_books->fetch_assoc();
    $response['books_available'] = $row['books_available'];
}

$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

<?php
header('Content-Type: application/json');

// Database connection details
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
    $bookId = $_POST['remove-book-id'];

    // Remove book from database
    $sql = "DELETE FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die(json_encode(['error' => 'Error preparing statement: ' . $conn->error]));
    }
    $stmt->bind_param("s", $bookId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Book not found']);
        }
    } else {
        echo json_encode(['error' => 'Error removing book: ' . $stmt->error]);
    }
    $stmt->close();
}
$conn->close();
?>

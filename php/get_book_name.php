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
    if (isset($_POST['book-id'])) {
        $bookId = $_POST['book-id'];

        $sql = "SELECT book_name FROM books WHERE book_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die(json_encode(['error' => 'Error preparing statement: ' . $conn->error]));
        }
        $stmt->bind_param("s", $bookId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode(['book_name' => $row['book_name']]);
        } else {
            echo json_encode(['book_name' => '']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Invalid request.']);
    }
}
$conn->close();
?>

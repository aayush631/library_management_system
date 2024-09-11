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
    // Fetch book name based on book ID
    if (isset($_POST['book-id']) && empty($_POST['book-name']) && empty($_POST['remove-book-id'])) {
        $bookId = $_POST['book-id'];
        
        // Query to get the book name
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
        
    } elseif (isset($_POST['remove-book-id']) && empty($_POST['book-name'])) {
        // Handle removing a book
        $removeBookId = $_POST['remove-book-id'];

        $sql_remove = "DELETE FROM books WHERE book_id = ?";
        $stmt_remove = $conn->prepare($sql_remove);
        if ($stmt_remove === false) {
            die(json_encode(['error' => 'Error preparing statement: ' . $conn->error]));
        }
        $stmt_remove->bind_param("s", $removeBookId);

        if ($stmt_remove->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error removing book: ' . $stmt_remove->error]);
        }
        $stmt_remove->close();

    } elseif (isset($_POST['book-id']) && isset($_POST['book-name']) && isset($_POST['location-rack']) && isset($_POST['status'])) {
        // Handle adding a new book
        $bookId = $_POST['book-id'];
        $bookName = $_POST['book-name'];
        $locationRack = $_POST['location-rack'];
        $status = $_POST['status'];

        // Check if book ID already exists
        $sql_check = "SELECT * FROM books WHERE book_id = ?";
        $stmt_check = $conn->prepare($sql_check);
        if ($stmt_check === false) {
            die(json_encode(['error' => 'Error preparing statement: ' . $conn->error]));
        }
        $stmt_check->bind_param("s", $bookId);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo json_encode(['error' => 'Book ID already exists in the database.']);
        } else {
            // Insert book into database
            $sql = "INSERT INTO books (book_id, book_name, location_rack, status) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die(json_encode(['error' => 'Error preparing statement: ' . $conn->error]));
            }
            $stmt->bind_param("ssss", $bookId, $bookName, $locationRack, $status);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Error adding book: ' . $stmt->error]);
            }
            $stmt->close();
        }
        $stmt_check->close();

    } else {
        echo json_encode(['error' => 'Invalid request.']);
    }
}
$conn->close();
?>

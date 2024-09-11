<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$response = [];

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $sql = "SELECT book_id, Book_Name FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]));
    }
    $stmt->bind_param("s", $book_id);
} elseif (isset($_GET['book_name'])) {
    $book_name = $_GET['book_name'];
    $sql = "SELECT book_id, Book_Name FROM books WHERE Book_Name LIKE ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]));
    }
    $like_book_name = "%" . $book_name . "%";
    $stmt->bind_param("s", $like_book_name);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if (isset($_GET['book_id'])) {
        $book = $result->fetch_assoc();
        if ($book) {
            $response = ['success' => true, 'book' => ['id' => $book['book_id'], 'name' => $book['Book_Name']]];
        } else {
            $response = ['success' => false, 'message' => 'No book found'];
        }
    } elseif (isset($_GET['book_name'])) {
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = ['id' => $row['book_id'], 'name' => $row['Book_Name']];
        }
        if (count($books) > 0) {
            $response = ['success' => true, 'books' => $books];
        } else {
            $response = ['success' => false, 'message' => 'No books found'];
        }
    }
} else {
    $response = ['success' => false, 'message' => 'Error executing statement: ' . $stmt->error];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>

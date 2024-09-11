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

$user_id = $_GET['user_id'];
$book_id = $_GET['book_id'];

$sql = "SELECT * FROM issued_books WHERE user_id = ? AND book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_id, $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();
    $current_date = date('Y-m-d');
    $fine = 0;

    if (strtotime($current_date) > strtotime($book['return_date'])) {
        $overdue_days = (strtotime($current_date) - strtotime($book['return_date'])) / 86400;
        $fine = max(0, $overdue_days * 10);
    }

    echo json_encode([
        'success' => true, 
        'book_name' => $book['book_name'], 
        'user_id' => $book['user_id'], 
        'user_fullname' => $book['user_fullname'], 
        'return_date' => $book['return_date'], 
        'fine' => $fine
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'No issued book found.']);
}

$stmt->close();
$conn->close();
?>

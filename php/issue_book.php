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

$data = json_decode(file_get_contents('php://input'), true);

$bookId = $data['bookId'];
$bookName = $data['bookName'];
$userId = $data['userId'];
$userFullname = $data['userFullname'];
$issuedDate = $data['issuedDate'];
$returnDate = $data['returnDate'];
$remarks = $data['remarks'];

$sql = "INSERT INTO issued_books (book_id, book_name, user_id, user_fullname, issued_date, return_date, remarks) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $bookId, $bookName, $userId, $userFullname, $issuedDate, $returnDate, $remarks);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

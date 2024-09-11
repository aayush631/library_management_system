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

$book_id = $data['bookId'];
$book_name = $data['bookName'];
$user_id = $data['userId'];
$user_fullname = $data['userFullname'];
$last_issued_date = $data['lastIssuedDate'];
$return_date = $data['returnDate'];
$fine = $data['fine'];
$status = $data['status'];

$conn->begin_transaction();

try {
    $sql = "INSERT INTO received_books (book_id, user_id, user_fullname, last_issued_date, returned_date, fine, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssis", $book_id, $user_id, $user_fullname, $last_issued_date, $return_date, $fine, $status);

    if ($stmt->execute()) {
        $update_sql = "UPDATE books SET status = 'available' WHERE book_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("s", $book_id);
        $update_stmt->execute();

        $delete_sql = "DELETE FROM issued_books WHERE book_id = ? AND user_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("ss", $book_id, $user_id);
        $delete_stmt->execute();

        $conn->commit();
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to receive book.');
    }
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>

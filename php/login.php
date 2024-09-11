<?php
session_start();

// Database connection details
$servername = "localhost"; // Change this to your database server
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "library_management"; // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    // Validate user credentials
    $sql = "SELECT * FROM users WHERE userid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password']; // Assuming 'password' column stores plain text

        // Verify password
        if ($password == $stored_password) {
            // Password correct, set session variables
            $_SESSION['userid'] = $userid;
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['email'] = $row['email']; // Add email to session if needed

            // Redirect to user panel or profile page
            header("Location: ../user/userpanel.php"); // Adjust path as necessary
            exit();
        } else {
            // Password incorrect
            echo "<script>
                alert('Incorrect password. Please try again.');
                window.location.href = '../user/login.html';
            </script>";
            exit();
        }
    } else {
        // User not found
        echo "<script>
            alert('User ID not found. Please sign up.');
            window.location.href = '../user/signup.html';
        </script>";
        exit();
    }
}

$conn->close();
?>
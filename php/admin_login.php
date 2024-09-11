<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get admin ID and password from the form
    $adminId = $_POST['admin-id'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $sql = "SELECT * FROM admins WHERE adminid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the password (plain text comparison)
        if ($password === $row['admin_password']) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_fullname'] = $row['admin_fullname'];
            header("Location: ../admin/admindashboard.html");
            exit();
        } else {
            $error_message = "Invalid Admin ID or Password.";
        }
    } else {
        $error_message = "Invalid Admin ID or Password.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Library Management System</title>
    <link rel="stylesheet" href="../php/adminlogin.css">
</head>
<body>
    <div class="container">
        <a href="../admin/admin_home.html" class="back-link">&larr; Back</a>
        <form id="login-form" action="../php/admin_login.php" method="post">
            <h2>Admin Login</h2>
            <div class="form-group">
                <label for="admin-id">Admin ID:</label>
                <input type="text" id="admin-id" name="admin-id" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <div class="checkbox-group">
                    <input type="checkbox" id="show-password">
                    <label for="show-password">Show Password</label>
                </div>
            </div>
            <button type="submit">Login</button>
            <?php if (isset($error_message)): ?>
                <p id="error-message" class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
        </form>
    </div>
    <script>
        // Script to toggle password visibility
        const showPassword = document.getElementById('show-password');
        const passwordField = document.getElementById('password');

        showPassword.addEventListener('change', function() {
            if (this.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        });
    </script>
</body>
</html>

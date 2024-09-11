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
    // Get data from the form
    $adminFullname = $_POST['admin-fullname'];
    $adminId = $_POST['admin-id'];
    $password = $_POST['password'];
    $countryCode = $_POST['country-code'];
    $adminPhone = $_POST['admin-phone'];

    // Combine country code and phone number
    $fullPhoneNumber = $countryCode . $adminPhone;

    // Prepare and execute the SQL statement to insert the new admin
    $sql = "INSERT INTO admins (adminid, admin_password, admin_fullname, admin_phone) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $adminId, $password, $adminFullname, $fullPhoneNumber);

    if ($stmt->execute()) {
        // JavaScript alert for successful signup and redirect to login page
        echo "<script>
            alert('New Admin record created successfully');
            window.location.href = '../php/admin_login.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Error: Could not create the account. Please try again.');
        </script>";
        echo "Error: " . $stmt->error;
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
    <title>Admin Sign Up - Library Management System</title>
    <link rel="stylesheet" href="../admin/src/adminsignup.css">
</head>
<body>
    <div class="container">
        <a href="../admin/admin_home.html" class="back-link">&larr; Back</a>
        <form id="signup-form" action="../php/admin_signup.php" method="post">
            <h2>Admin Sign Up</h2>
            <div class="form-group">
                <label for="admin-fullname">Full Name:</label>
                <input type="text" id="admin-fullname" name="admin-fullname" required>
            </div>
            <div class="form-group">
                <label for="admin-id">Admin ID:</label>
                <input type="text" id="admin-id" name="admin-id" required>
            </div>
            <div class="form-group">
                <label for="admin-phone">Phone Number:</label>
                <div class="phone-input">
                    <select id="country-code" name="country-code" required>
                        <option value="+977">Nepal (+977)</option>
                        <option value="+91">India (+91)</option>
                        <!-- Add more country codes as needed -->
                    </select>
                    <input type="text" id="admin-phone" name="admin-phone" placeholder="Enter your phone number" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group checkbox-group">
                <input type="checkbox" id="show-password">
                <label for="show-password">Show Password</label>
            </div>
            <button type="submit">Sign Up</button>
            <?php if (!empty($error_message)): ?>
                <p id="error-message" class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <?php if (!empty($success_message)): ?>
                <p id="success-message" class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
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

<?php
session_start(); // Start the session

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

// Debug: Check session data
if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
    $fullname = $_SESSION['fullname']; // Retrieve fullname from session
} else {
    die("No user ID found in session.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Library Management System</title>
    <link rel="stylesheet" href="./src/userpanel.css">
</head>
<body>
    <header>
        <div class="container">
            <img src="../icons/logo-1.png" alt="Logo" id="logo">
            <nav>
                <ul class="menu">
                    <li><a href="./userpanel.php" class="active">Home</a></li>
                    <li><a href="../php/borrowed.php">Borrowed Books</a></li>
                    <li><a href="./aboutus.html">About Us</a></li>
                    <li><a href="../php/userprofile.php">Profile</a></li>
                    <li><a href="./landing.html">Logout</a></li>
                    <li><a href="#" id="notification-bell">
                        <img src="../icons/bell.png" alt="Notifications">
                    </a></li>
                </ul>
                <div class="hamburger-menu" id="hamburger-menu">
                    <div class="hamburger-icon" id="hamburger-icon">&#9776;</div>
                </div>
                <div class="responsive-menu" id="responsive-menu">
                    <div class="close-icon" id="close-icon">&times;</div>
                    <ul>
                        <li><a href="./userpanel.php" class="active">Home</a></li>
                        <li><a href="../php/borrowed.php">Borrowed Books</a></li>
                        <li><a href="./aboutus.html">About Us</a></li>
                        <li><a href="../php/userprofile.php">Profile</a></li>
                        <li><a href="#" id="responsive-notifications">Notifications</a></li>
                        <li><a href="./landing.html">Logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <section class="welcome">
                <h2>Welcome, <?php echo htmlspecialchars($fullname); ?></h2>
                <p>What would you like to do today?</p>
            </section>
            <section class="actions">
                <div class="action-item">
                    <a href="../php/borrowed.php" class="action-link">
                        <img src="../icons/book.png" alt="Borrowed Books">
                        <h3>View Borrowed Books</h3>
                    </a>
                </div>
                <div class="action-item">
                    <a href="./aboutus.html" class="action-link">
                        <img src="../icons/information-button.png" alt="About Us">
                        <h3>About Us</h3>
                    </a>
                </div>
                <div class="action-item">
                    <a href="../php/userprofile.php" class="action-link">
                        <img src="../icons/profile-user.png" alt="Profile">
                        <h3>Go to Profile</h3>
                    </a>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Library Management System. All rights reserved.</p>
        </div>
    </footer>

    <div id="notification-panel" class="notification-panel">
        <div class="notification-content">
            <h2>Notifications</h2>
            <ul id="notification-list">
                <!-- Notifications will be dynamically loaded here -->
            </ul>
            <button id="close-notifications">Close</button>
        </div>
    </div>

    <script src="./src/userpanel.js"></script>
</body>
</html>

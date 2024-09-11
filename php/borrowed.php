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

// Get user_id from session
$user_id = $_SESSION['userid'];

// Query to get issued books for the logged-in user
$sql = "SELECT book_id, book_name, issued_date, return_date FROM issued_books WHERE user_id = '$user_id'";
$result = $conn->query($sql);

$issued_books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $issued_books[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books - Library Management System</title>
    <link rel="stylesheet" href="../user/src/borrowed.css">
</head>
<body>
    <header>
        <div class="container">
            <img src="../icons/logo-1.png" alt="Logo" id="logo">
            <nav>
                <ul class="menu">
                    <li><a href="../user/userpanel.php">Home</a></li>
                    <li><a href="./borrowed.php" class="active">Borrowed Books</a></li>
                    <li><a href="../user/aboutus.html">About Us</a></li>
                    <li><a href="./userprofile.php">Profile</a></li>
                    <li><a href="../user/landing.html">Logout</a></li>
                </ul>
                <div class="hamburger-menu" id="hamburger-menu">
                    <div class="hamburger-icon" id="hamburger-icon">&#9776;</div>
                </div>
                <div class="responsive-menu" id="responsive-menu">
                    <div class="close-icon" id="close-icon">&times;</div>
                    <ul>
                        <li><a href="../user/userpanel.php">Home</a></li>
                        <li><a href="./borrowed.php" class="active">Borrowed Books</a></li>
                        <li><a href="../user/aboutus.html">About Us</a></li>
                        <li><a href="./userprofile.php">Profile</a></li>
                        <li><a href="../user/landing.html">Logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <section class="search-section">
                <input type="text" id="search" placeholder="Search for a book...">
            </section>
            <section class="table-section">
                <table id="books-table">
                    <thead>
                        <tr>
                            <th>Book Id</th>
                            <th>Book Name</th>
                            <th>Issued Date</th>
                            <th>Return Date</th>
                            <th>Fines</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($issued_books as $book): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book['book_id']); ?></td>
                            <td><?php echo htmlspecialchars($book['book_name']); ?></td>
                            <td><?php echo htmlspecialchars($book['issued_date']); ?></td>
                            <td><?php echo htmlspecialchars($book['return_date']); ?></td>
                            <td class="fines">Rs. 0</td>
                            <td class="status">Not Returned</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Library Management System. All rights reserved.</p>
        </div>
    </footer>
    <script src="../user/src/borrowed.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const responsiveMenu = document.getElementById('responsive-menu');
    const closeIcon = document.getElementById('close-icon');

    // Toggle the responsive menu
    hamburgerIcon.addEventListener('click', () => {
        responsiveMenu.style.display = 'flex';
    });

    closeIcon.addEventListener('click', () => {
        responsiveMenu.style.display = 'none';
    });

    // Close the responsive menu when clicking outside of it
    window.addEventListener('click', (event) => {
        if (event.target == responsiveMenu) {
            responsiveMenu.style.display = 'none';
        }
    });
});

    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Feedback</title>
    <link rel="stylesheet" href="../admin/src/admin_feedback.css">

    <script>
        function toggleHighlight(feedbackId, button) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "highlight_feedback.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    if (xhr.responseText === "highlighted") {
                        button.classList.remove('not-highlighted');
                        button.classList.add('highlighted');
                    } else if (xhr.responseText === "not_highlighted") {
                        button.classList.remove('highlighted');
                        button.classList.add('not-highlighted');
                    }
                    // Refresh the page after the status update
                    window.location.reload();
                }
            };
            xhr.send("feedback_id=" + feedbackId);
        }
    </script>
</head>
<body>
    <header>
        <div class="container">
            <img src="../icons/logo-1.png" alt="Logo" id="logo">
            <nav>
                <ul>
                    <li><a href="../admin/admindashboard.html">Home</a></li>
                    <li><a href="../admin/add-remove.html">Manage Users</a></li>
                    <li><a href="../admin/add-removebook.html">Manage Books</a></li>
                    <li><a href="../admin/location.html">Location & Rack</a></li>
                    <li><a href="../admin/issue.html">Issue Books</a></li>
                    <li><a href="../admin/receive.html">Receive Books</a></li>
                    <li><a href="../user/landing.html">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <h1>User Feedback</h1>
            <table id="feedback-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Date</th>
                        <th>Feedback</th>
                        <th>Highlight</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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

                    // Fetch feedback from the database
                    $sql = "SELECT id, userid, fullname, feedback, DATE_FORMAT(feedback_date, '%Y-%m-%d') as date, highlighted FROM feedback ORDER BY feedback_date DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $highlightedClass = $row['highlighted'] ? 'highlighted' : 'not-highlighted';
                            echo "<tr>
                                    <td>{$row['userid']}</td>
                                    <td>{$row['fullname']}</td>
                                    <td>{$row['date']}</td>
                                    <td>{$row['feedback']}</td>
                                    <td>
                                        <button class='heart-button $highlightedClass' onclick='toggleHighlight({$row['id']}, this)'>
                                            ♥
                                        </button>
                                        " . ($row['highlighted'] ? "<span class='highlighted-message'>Highlighted</span>" : "") . "
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No feedback found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Library Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

<?php 
session_start(); 
require 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Members</title>
    <link rel="stylesheet" href="view.css">
    <style>
        /* Add any additional inline styles if necessary */
        .btn {
            display: inline-flexbox;
            padding: 10px 20px;
            background:linear-gradient(to right, #3f5efb, #fc466b);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <form method="POST" action="">
                        <input type="text" name="search_query" placeholder="Search..." id="search-input">
                        <button type="submit"><img src="Gallery/icons8-search-30.png" alt="Search"></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="new-members">
                <div class="title">
                    <h2>OUR MEMBERS</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Year</th>
                            <th>Reg. No.</th>
                            <th>Course</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="members-table">
                        <?php
                        // Handle search query
                        $search_query = "";
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $search_query = $_POST['search_query'];
                        }

                        // Fetch members from database
                        $sql = "SELECT id, profilePicture, name, email, phone, yearOfStudy, regNumber, courseOfStudy FROM members";
                        if (!empty($search_query)) {
                            $sql .= " WHERE name LIKE '%$search_query%' OR email LIKE '%$search_query%' OR phone LIKE '%$search_query%' OR regNumber LIKE '%$search_query%' OR courseOfStudy LIKE '%$search_query%'";
                        }
                        $sql .= " ORDER BY id DESC";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><img src='" . $row["profilePicture"] . "' alt='Profile' class='profile-img'></td>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["phone"] . "</td>";
                                echo "<td>" . $row["yearOfStudy"] . "</td>";
                                echo "<td>" . $row["regNumber"] . "</td>";
                                echo "<td>" . $row["courseOfStudy"] . "</td>";
                                echo "<td><a href='edit_member.php?id=" . $row["id"] . "' class='btn'>Edit</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No members found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <br>
                <a href="Member.php" class="btn">Add Member</a>
                <a href="dashboard.php" class="btn">Back to Dashboard</a>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 All Rights Reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>

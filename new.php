<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-left: 250px; /* Adjusted to accommodate the side menu */
            padding: 20px;
        }

        .side-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #0f64e4;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .brand-name h1 {
            margin: 20px 0;
        }

        .side-menu ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
        }

        .side-menu ul li {
            width: 100%;
        }

        .side-menu ul li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .side-menu ul li a:hover {
            background-color: #005bb5;
        }

        .side-menu ul li img {
            margin-right: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .search {
            display: flex;
            align-items: center;
        }

        .search input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .search button {
            padding: 10px;
            border: none;
            background-color: #0f64e4;
            color: white;
            cursor: pointer;
            border-radius: 0 4px 4px 0;
        }

        .search button img {
            width: 20px;
            height: 20px;
        }

        .user .btn {
            background-color: #0f64e4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 20px;
            transition: background-color 0.3s;
        }

        .user .btn:hover {
            background-color: #005bb5;
        }

        .content {
            display: flex;
            flex-direction: column;
        }

        .cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin: 0 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card h1 {
            font-size: 2em;
            margin: 0;
        }

        .card h3 {
            margin: 0;
            color: #555;
        }

        .icon-case {
            width: 50px;
            height: 50px;
        }

        .content-2 {
            display: flex;
            justify-content: space-between;
        }

        .recent-payments, .new-members {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 48%;
        }

        .title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .title h2 {
            margin: 0;
        }

        .title .btn {
            background-color: #0f64e4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .title .btn:hover {
            background-color: #005bb5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        .profile-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }

        footer {
            background-color: #0f64e4;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .footer-section {
            display: flex;
            flex-direction: column;
        }

        .footer-section h3 {
            margin-bottom: 10px;
        }

        .footer-section ul {
            list-style-type: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 5px;
        }

        .footer-section ul li a {
            color: white;
            text-decoration: none;
        }

        .footer-section ul li a:hover {
            text-decoration: underline;
        }

        .social-icons a img {
            width: 30px;
            height: 30px;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>UNESCO CLUB KyU</h1>
        </div>
        <ul>
            <li><a href="#"><img src="Gallery/icons8-dashboard-48.png" alt=""><span>Dashboard</span></a></li>
            <li><a href="view_members.php"><img src="Gallery/icons8-member-64.png" alt=""><span>Members</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-teacher-50.png" alt=""><span>Leaders</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-school-30.png" alt=""><span>Events</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-income-50.png" alt=""><span>Contributions</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-help-50.png" alt=""><span>Help</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-settings-50.png" alt=""><span>Settings</span></a></li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="search">
                <input type="text" placeholder="Search...">
                <button type="submit"><img src="Gallery/icons8-search-30.png" alt=""></button>
            </div>
            <div class="user">
                <a href="Member.php" class="btn">Add New</a>
                <img src="Gallery/icons8-notification-50.png" alt="">
                <div class="img-case">
                    <img src="Gallery/icons8-user-30.png" alt="">
                </div>
            </div>
        </div>
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h1>
                            <?php
                            $sql = "SELECT COUNT(*) AS total_members FROM members";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo $row['total_members'];
                            } else {
                                echo '0';
                            }
                            ?>
                        </h1>
                        <h3>Members</h3>
                    </div>
                    <div class="icon-case">
                        <img src="Gallery/icons8-member-64.png" alt="">
                    </div>
                </div>

                <div class="card">
                    <div class="box">
                        <h1>7</h1>
                        <h3>Leaders</h3>
                    </div>
                    <div class="icon-case">
                        <img src="Gallery/icons8-teacher-50.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>5</h1>
                        <h3>Events</h3>
                    </div>
                    <div class="icon-case">
                        <img src="Gallery/icons8-school-30.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>
                            <?php
                            $sql = "SELECT SUM(amount) AS total_contributions FROM payments";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo 'Ksh.' . number_format($row['total_contributions'], 2);
                            } else {
                                echo 'Ksh.0.00';
                            }
                            ?>
                        </h1>
                        <h3>Contributions</h3>
                    </div>
                    <div class="icon-case">
                        <img src="Gallery/icons8-income-50.png" alt="">
                    </div>
                </div>
            </div>
            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Recent Payments</h2>
                        <a href="create_payment.php" class="btn">Add New</a>
                        <a href="view_payment.php" class="btn">View All</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Payment ID</th>
                                <th>Payment Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch recent payments from the database
                            $sql = "SELECT members.name, payments.payment_id, payments.payment_date, payments.amount
                                    FROM payments
                                    INNER JOIN members ON payments.member_id = members.id
                                    ORDER BY payments.payment_date DESC
                                    LIMIT 6";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["name"] . "</td>";
                                    echo "<td>" . $row["payment_id"] . "</td>";
                                    echo "<td>" . $row["payment_date"] . "</td>";
                                    echo "<td>Ksh." . number_format($row["amount"], 2) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No recent payments found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="new-members">
                    <div class="title">
                        <h2>New Members</h2>
                        <a href="view_members.php" class="btn">View All</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Year</th>
                                <th>Reg. No.</th>
                                <th>Course</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch new members from the database
                            $sql = "SELECT profilePicture, yearOfStudy, regNumber, courseOfStudy FROM members ORDER BY id DESC LIMIT 5";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><img src='" . $row["profilePicture"] . "' alt='Profile' class='profile-img'></td>";
                                    echo "<td>" . $row["yearOfStudy"] . "</td>";
                                    echo "<td>" . $row["regNumber"] . "</td>";
                                    echo "<td>" . $row["courseOfStudy"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No new members found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer-section">
                <h3>About Us</h3>
                <ul>
                    <li><a href="#">Our Mission</a></li>
                    <li><a href="#">Our Team</a></li>
                    <li><a href="#">Careers</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Resources</h3>
                <ul>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section social-icons">
                <a href="#"><img src="Gallery/icons8-facebook-50.png" alt="Facebook"></a>
                <a href="#"><img src="Gallery/icons8-twitter-50.png" alt="Twitter"></a>
                <a href="#"><img src="Gallery/icons8-instagram-50.png" alt="Instagram"></a>
                <a href="#"><img src="Gallery/icons8-linkedin-50.png" alt="LinkedIn"></a>
            </div>
        </footer>
    </div>
    <!-- JavaScript -->
    <script src="script.js"></script>
</body>
</html>

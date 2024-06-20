<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <?php
    // Starting session
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if user is not logged in
        header("Location: login.php");
        exit();
    }

    // Include database connection
    include 'db_connection.php';
    ?>
</head>
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>UNESCO KyU.</h1>
        </div>
        <ul>
            <li><a href="#"><img src="Gallery/icons8-dashboard-48.png" alt="Dashboard"><span>Dashboard</span></a></li>
            <li><a href="member_login.php"><img src="Gallery/icons8-member-64.png" alt="Members"><span>Members</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-teacher-50.png" alt="Leaders"><span>Leaders</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-school-30.png" alt="Events"><span>Events</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-income-50.png" alt="Contributions"><span>Contributions</span></a></li>
            <li><a href="help.php"><img src="Gallery/icons8-help-50.png" alt="Help"><span>Help</span></a></li>
            <li><a href="settings.php"><img src="Gallery/icons8-settings-50.png" alt="Settings"><span>Settings</span></a></li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" name="search_query" placeholder="Search..." id="search-input">
                    <button type="submit"><img src="Gallery/icons8-search-30.png" alt="Search"></button>
                </div>
                <div class="user">
                    <a href="Member.php" class="btn">Add New</a>
                    <a href="login.php" class="btn btn-secondary">Logout</a>
                    <div class="img-case">
                        <?php
                        // Retrieve user ID from the session
                        $userID = $_SESSION['id'];

                        // Query the database for the user's profile picture
                        $sql = "SELECT ProfilePicture FROM members WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $userID);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Display the profile picture or a default icon
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $profilePicture = htmlspecialchars($row['ProfilePicture']);
                            if (!empty($profilePicture)) {
                                echo '<img src="' . $profilePicture . '" alt="Profile Picture">';
                            } else {
                                echo '<img src="Gallery/icons8-user-30.png" alt="Default Icon">';
                            }
                        }
                        // Close the database connection
                        $stmt->close();
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h1>
                            <?php
                            // Reconnect to the database for card queries
                            include 'db_connection.php';
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
                        <img src="Gallery/icons8-member-64.png" alt="Members">
                    </div>
                </div>

                <div class="card">
                    <div class="box">
                        <h1>7</h1>
                        <h3>Leaders</h3>
                    </div>
                    <div class="icon-case">
                        <img src="Gallery/icons8-teacher-50.png" alt="Leaders">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>5</h1>
                        <h3>Events</h3>
                    </div>
                    <div class="icon-case">
                        <img src="Gallery/icons8-school-30.png" alt="Events">
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
                        <img src="Gallery/icons8-income-50.png" alt="Contributions">
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
                                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["payment_id"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["payment_date"]) . "</td>";
                                    echo "<td>Ksh." . htmlspecialchars($row["amount"]) . "</td>";
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
                            $sql = "SELECT ProfilePicture, yearOfStudy, regNumber, courseOfStudy FROM members ORDER BY id DESC LIMIT 5";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><img src='" . htmlspecialchars($row["ProfilePicture"]) . "' alt='Profile' class='profile-img'></td>";
                                    echo "<td>" . htmlspecialchars($row["yearOfStudy"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["regNumber"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["courseOfStudy"]) . "</td>";
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

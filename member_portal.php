<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: member_login.php");
    exit;
}

include 'db_connection.php';

$id = $_SESSION["id"];

// Initialize variables for member details and profile picture
$member = [];
$profilePicture = '';

// Fetch member details including profile picture
$sql = "SELECT * FROM members WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $param_id);
    $param_id = $id;

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $member = $row;
            $profilePicture = $row['profilePicture']; // Assuming 'profilePicture' is the column name in the database
        } else {
            echo "Member not found.";
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to left, #3f5efb, #fc466b);
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            opacity: 0.9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            float: left;
            width: 200px;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar ul {
            list-style-type: none;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            display: block;
            padding: 8px;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
        }

        .sidebar ul li a:hover {
            background-color: #ddd;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
            background: linear-gradient(to right, #3f5efb, #fc466b);
            padding: 15px;
            border-radius: 4px;
        }

        .logo img {
            width: 65px;
            height: 65px;
            border-radius: 5px;
            float: left;
            margin-bottom: 5px;
        }

        .profile {
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            max-width: max-content;
            margin: 20px auto;
        }

        .profile-picture {
            display: block;
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-picture img {
            width: 150px;
            height: auto;
            max-width: 220px;
            height: auto;
            border-radius: 10%;
        }

        .table th, .table td {
            padding: 10px;
        }

        .card-header {
            background-color: #f7f7f7;
            border-bottom: 1px solid #ddd;
        }

        .card {
            margin-top: 20px;
        }
        .footer-details{
            text-align: center;
            background-color: #f7f7f7;
            border-top: 1px solid #ddd;
            padding: 10px;
            margin-top: 10px;
        }
        .footer-details p{
            margin-bottom: 0;
            font-size: 14px;
            color: #777;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                margin-bottom: 20px;
                display: none;
            }

            .content {
                margin-left: 0;
            }

            .logo {
                text-align: center;
            }

            .profile {
                max-width: 100%;
            }

            .table th, .table td {
                padding: 5px;
            }

            .card {
                margin-top: 10px;
            }
            
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <ul>
            <li><a href="/Wegner-Devs/Unesco/Home_u.html">Home</a></li>
            <li><a href="member_portal.php">Events</a></li>
            <li><a href="payments.php">Announcements</a></li>
            <li><a href="#">Downloads</a></li>
            <li><a href="contributions.php">Contributions</a></li>
            <li><a href="member_login.php">Log Out</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="logo">
            <img src="Gallery/Unesco_logo.jpeg" alt="Logo">
            <h1>UNESCO KyU</h1>
        </div>
        <div class="profile">
            <div class="profile-picture">
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
            <h2><?php echo htmlspecialchars($member["name"]); ?></h2>
            <p>Course Of Study: <?php echo htmlspecialchars($member["courseOfStudy"]); ?></p>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Welcome, <?php echo htmlspecialchars($member["name"]); ?></h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Email:</th>
                                        <td><?php echo htmlspecialchars($member["email"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td><?php echo htmlspecialchars($member["phone"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Year Of Study:</th>
                                        <td><?php echo htmlspecialchars($member["yearOfStudy"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Registration Number:</th>
                                        <td><?php echo htmlspecialchars($member["regNumber"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date Of Birth:</th>
                                        <td><?php echo htmlspecialchars($member["dob"]); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>

                    <div class="edit-details mt-4">
                <button id="edit-button" class="btn btn-primary">Edit Details</button>
                <form id="edit-form" action="update.php" method="post" class="mt-3" style="display: none;">
                    <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $member['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $member['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $member['phone']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control" value="<?php echo $member['dob']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Year of Study</label>
                        <input type="text" name="yearOfStudy" class="form-control" value="<?php echo $member['yearOfStudy']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Registration Number</label>
                        <input type="text" name="regNumber" class="form-control" value="<?php echo $member['regNumber']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Course of Study</label>
                        <input type="text" name="courseOfStudy" class="form-control" value="<?php echo $member['courseOfStudy']; ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
            <p class="mt-4"><a href="member_login.php" class="btn btn-secondary">Logout</a></p>
        </div>
                    <hr style="height:2px;border-width:0;color:gray;background-color:gray"><br>
                </div>
            </div>
        </div>
        <div class="footer-details">
            <h3>UNESCO KyU</h3>
            <p><h3>PEACE IN MIND!!</h3></p>
            <p>&copy;  <i><i class="fa fa-copyright" aria-hidden="true"></i>UNESCO 2024 All Rights Reserved.</p>
        </div>
    </div>
</div>
<script src="js/scripts.js"></script>
</body>
</html>

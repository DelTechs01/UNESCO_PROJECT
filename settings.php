<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        /* Reset default margin and padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0; /* Light background color */
    color: #333; /* Text color */
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

h1, h2, h3 {
    margin-bottom: 10px;
}

/* Form styles */
form {
    margin-bottom: 20px;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 10px;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

button[type="submit"] {
    background: linear-gradient(to right, #4CAF50, #45a049); /* Green submit button */
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button[type="submit"]:hover {
    background-color: #45a049; /* Darker green on hover */
}

/* Link styles */
a {
    color: #007bff; /* Blue link color */
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Sidebar styles */
.side-menu {
    background: linear-gradient(to right, #3f5efb, #fc466b); /* Dark sidebar background */
    color: #fff; /* Sidebar text color */
    width: 250px;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
    padding-top: 20px;
}

.side-menu .brand-name h1 {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

.side-menu ul {
    list-style-type: none;
    padding-left: 0;
}

.side-menu ul li {
    padding: 10px;
    margin-bottom: 5px;
}

.side-menu ul li a {
    display: flex;
    align-items: center;
    color: #fff;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.side-menu ul li a:hover {
    background-color: #555; /* Darker background on hover */
}

.side-menu ul li a img {
    margin-right: 10px;
}

.side-menu ul li a span {
    font-size: 16px;
}

/* Main content styles */
.main-content {
    margin-left: 250px; /* Adjust for sidebar width */
    padding: 20px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .side-menu {
        width: 100%;
        height: auto;
        position: relative;
        margin-bottom: 20px;
    }

    .main-content {
        margin-left: 0;
    }
}

    </style>
</head>
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>UNESCO KyU.</h1>
        </div>
        <ul>
            <li><a href="dashboard.php"><img src="Gallery/icons8-dashboard-48.png" alt="Dashboard"><span>Dashboard</span></a></li>
            <li><a href="member_login.php"><img src="Gallery/icons8-member-64.png" alt="Members"><span>Members</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-teacher-50.png" alt="Leaders"><span>Leaders</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-school-30.png" alt="Events"><span>Events</span></a></li>
            <li><a href="#"><img src="Gallery/icons8-income-50.png" alt="Contributions"><span>Contributions</span></a></li>
            <li><a href="help.php"><img src="Gallery/icons8-help-50.png" alt="Help"><span>Help</span></a></li>
            <li><a href="settings.php"><img src="Gallery/icons8-settings-50.png" alt="Settings"><span>Settings</span></a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="container">
            <h1>Settings</h1>
            <form action="update_settings.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>

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
    <title>Help</title>
    <style>
        /* General Styles for Help Page */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}

.container {
    margin-left: 250px;
    padding: 20px;
}

/* Side Menu Styles */
.side-menu {
    width: 250px;
    height: 100%;
    position: fixed;
    background: linear-gradient(to right, #3f5efb, #fc466b);
    padding-top: 20px;
}

.side-menu .brand-name h1 {
    color: #ecf0f1;
    text-align: center;
    margin-bottom: 20px;
}

.side-menu ul {
    list-style: none;
    padding: 0;
}

.side-menu ul li {
    padding: 15px 10px;
    border-bottom: 1px solid #34495e;
}

.side-menu ul li a {
    color: #ecf0f1;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.side-menu ul li a img {
    margin-right: 10px;
}

.side-menu ul li:hover {
    background-color: #34495e;
}

/* Help Page Styles */
h1, h2 {
    color: #2c3e50;
}

.faq-section, .contact-section {
    margin-bottom: 20px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.faq-section h2, .contact-section h2 {
    border-bottom: 2px solid #2c3e50;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.faq {
    margin-bottom: 15px;
}

.faq h3 {
    margin: 0 0 10px 0;
    color: #2980b9;
}

.faq p {
    margin: 0;
}

form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

form input, form textarea, form button {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form button {
    background-color: #2980b9;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #3498db;
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
    <div class="container">
        <h1>Help Center</h1>
        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="faq">
                <h3>How do I reset my password?</h3>
                <p>You can reset your password by going to the settings page and clicking on "Change Password".</p>
            </div>
            <div class="faq">
                <h3>How do I contact support?</h3>
                <p>You can contact support by emailing support@example.com or calling 123-456-7890.</p>
            </div>
            <!-- Add more FAQs as needed -->
        </div>
        <div class="contact-section">
            <h2>Contact Us</h2>
            <form action="submit_help_request.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>

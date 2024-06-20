<?php
session_start();
include 'db_connection.php'; // Adjust the path as per your file structure

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Initialize variables for feedback messages
$current_password_error = '';
$new_password_error = '';
$confirm_password_error = '';
$success_message = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if current password matches the one in the database
    $sql = "SELECT password FROM members WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];
        if (!password_verify($current_password, $stored_password)) {
            $current_password_error = "Current password is incorrect.";
        }
    }

    // Validate new password
    if (empty($new_password)) {
        $new_password_error = "Please enter a new password.";
    } elseif (strlen($new_password) < 6) {
        $new_password_error = "Password must be at least 6 characters long.";
    }

    // Validate confirm password
    if (empty($confirm_password)) {
        $confirm_password_error = "Please confirm your password.";
    } elseif ($new_password != $confirm_password) {
        $confirm_password_error = "Passwords do not match.";
    }

    // If no errors, update password
    if (empty($current_password_error) && empty($new_password_error) && empty($confirm_password_error)) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password in the database
        $update_sql = "UPDATE members SET password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            $success_message = "Password updated successfully.";
        } else {
            $current_password_error = "Failed to update password. Please try again.";
        }

        $update_stmt->close();
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
    <title>Change Password</title>
    <link rel="stylesheet" href="pay.css"> <!-- Adjust the path to your stylesheet -->
    <style>
        /* Add any additional styling here */
    </style>
</head>
<body>
    <div class="containers">
        <h1>Change Password</h1>
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
                <span class="error"><?php echo $current_password_error; ?></span>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                <span class="error"><?php echo $new_password_error; ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="error"><?php echo $confirm_password_error; ?></span>
            </div>
            <div class="form-group">
                <button type="submit">Change Password</button>
            </div>
        </form>
        <br>
        <a href="Index.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>

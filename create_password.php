<?php
session_start();
include 'db_connection.php'; // Include your database connection script

// Initialize variables
$name = "";
$email = "";
$password = "";
$nameErr = $emailErr = $passwordErr = "";
$success_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input fields
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email format is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        // Password hashing for security (you can use PHP password_hash function)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // If no errors, proceed to insert password into database
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr)) {
        // Check if user exists with given name and email
        $check_user_sql = "SELECT * FROM members WHERE name = ? AND email = ?";
        $stmt = $conn->prepare($check_user_sql);
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update user password
            $update_password_sql = "UPDATE members SET password = ? WHERE name = ? AND email = ?";
            $stmt = $conn->prepare($update_password_sql);
            $stmt->bind_param("sss", $hashed_password, $name, $email);
            if ($stmt->execute()) {
                $success_message = "Password updated successfully.";
            } else {
                $passwordErr = "Error updating password.";
            }
        } else {
            $passwordErr = "User not found. Please check your name and email.";
        }

        $stmt->close();
    }

    // Close database connection
    $conn->close();
}

// Function to sanitize and validate input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Password</title>
    <link rel="stylesheet" href="create_password.css"> <!-- Adjust the path to your stylesheet -->
    <style>
        /* Additional styling can be added here */
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Password</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <span class="error"><?php echo $nameErr; ?></span>
            <br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <span class="error"><?php echo $emailErr; ?></span>
            <br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password">
            <span class="error"><?php echo $passwordErr; ?></span>
            <br><br>

            <input type="submit" value="Submit">
        </form>

        <span class="success"><?php echo $success_message; ?></span>
        <br><br>

        <a href="login.php">Back to Login</a>
    </div>
</body>
</html>

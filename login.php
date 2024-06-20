<?php
session_start();
include 'db_connection.php'; // Adjust the path as per your file structure

// Initialize variables for form input and errors
$regNumber = $password = '';
$regNumber_error = $password_error = '';
$login_error = '';

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate regNumber
    if (empty(trim($_POST['regNumber']))) {
        $regNumber_error = "Please enter your registration number.";
    } else {
        $regNumber = trim($_POST['regNumber']);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_error = "Please enter your password.";
    } else {
        $password = trim($_POST['password']);
    }

    // Proceed with login if there are no errors
    if (empty($regNumber_error) && empty($password_error)) {
        // Prepare SQL statement to retrieve hashed password
        $sql = "SELECT id, regNumber, password FROM members WHERE regNumber = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_regNumber);
            
            // Set parameters
            $param_regNumber = $regNumber;
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if regNumber exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $regNumber, $hashed_password);
                    if ($stmt->fetch()) {
                        // Debugging: Check fetched data
                        error_log("Fetched hashed password: " . $hashed_password);

                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION['id'] = $id;
                            $_SESSION['regNumber'] = $regNumber;
                            
                            // Redirect user to dashboard page
                            header("location: dashboard.php");
                            exit();
                        } else {
                            // Password is not valid
                            $login_error = "Invalid password.";
                            error_log("Password verification failed.");
                        }
                    }
                } else {
                    // No account found with that regNumber
                    $login_error = "No account found with that registration number.";
                    error_log("No account found with registration number: " . $regNumber);
                }
            } else {
                // Database execution error
                $login_error = "Oops! Something went wrong. Please try again later.";
                error_log("Database execution error: " . $stmt->error);
            }

            // Close statement
            $stmt->close();
        } else {
            // Prepare statement error
            $login_error = "Oops! Something went wrong. Please try again later.";
            error_log("Prepare statement error: " . $conn->error);
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="pay.css"> <!-- Adjust the path to your stylesheet -->
    <style>
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group .error {
            color: red;
            font-size: 0.9em;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
        }
        a {
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($regNumber_error)) ? 'has-error' : ''; ?>">
                <label>Registration Number</label>
                <input type="text" name="regNumber" value="<?php echo htmlspecialchars($regNumber); ?>">
                <span class="error"><?php echo $regNumber_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password">
                <span class="error"><?php echo $password_error; ?></span>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <?php if (!empty($login_error)) : ?>
                <div class="error-message"><?php echo $login_error; ?></div>
            <?php endif; ?>
        </form>
        <br>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>

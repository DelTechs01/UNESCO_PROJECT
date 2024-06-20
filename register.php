<?php
session_start();
include 'db_connection.php'; // Adjust as per your database connection script

// Initialize variables for form input and errors
$name = $email = $password = $regNumber = '';
$name_err = $email_err = $password_err = $regNumber_err = '';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        $email = trim($_POST["email"]);
        // Check if email is already registered
        $sql = "SELECT id FROM members WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $email_err = "This email is already taken.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        } else {
            echo "Error: Could not prepare query: $sql. " . $conn->error;
        }
    }

    // Validate registration number
    if (empty(trim($_POST["regNumber"]))) {
        $regNumber_err = "Please enter your registration number.";
    } else {
        $regNumber = trim($_POST["regNumber"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If no errors, proceed with registration
    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($regNumber_err)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL insert statement
        $sql = "INSERT INTO members (name, email, password, regNumber) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $regNumber);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        } else {
            echo "Error: Could not prepare query: $sql. " . $conn->error;
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
    <title>Register</title>
    <link rel="stylesheet" href="pay.css"> <!-- Adjust the path to your CSS file -->
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
                <span class="error"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($regNumber_err)) ? 'has-error' : ''; ?>">
                <label>Registration Number</label>
                <input type="text" name="regNumber" value="<?php echo htmlspecialchars($regNumber); ?>">
                <span class="error"><?php echo $regNumber_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password">
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>

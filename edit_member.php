<?php
session_start();
require 'db_connection.php';

// Initialize variables with default values
$profilePicture = $name = $email = $phone = $yearOfStudy = $regNumber = $courseOfStudy = '';
$error_message = '';

// Check if ID parameter is set and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $member_id = $_GET['id'];

    // Fetch member details from database using prepared statement
    $sql = "SELECT * FROM members WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $member_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $profilePicture = $row['profilePicture'];
            $name = $row['name'];
            $email = $row['email'];
            $phone = $row['phone'];
            $yearOfStudy = $row['yearOfStudy'];
            $regNumber = $row['regNumber'];
            $courseOfStudy = $row['courseOfStudy'];
        } else {
            $error_message = "Member not found.";
        }
    } else {
        $error_message = "Error retrieving member details: " . $stmt->error;
    }
    $stmt->close();
} else {
    $error_message = "Invalid member ID.";
}

// Handle form submission for updating member details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $yearOfStudy = $_POST['yearOfStudy'];
    $regNumber = $_POST['regNumber'];
    $courseOfStudy = $_POST['courseOfStudy'];

    // Check if a new profile picture was uploaded
    if ($_FILES['profilePicture']['size'] > 0) {
        // Handle file upload
        $target_dir = "uploads/"; // Specify the directory where you want to save uploaded files
        $target_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $error_message = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profilePicture"]["size"] > 500000) {
            $error_message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error_message = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
                $profilePicture = $target_file;
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Update member details in the database
    $sql_update = "UPDATE members SET name = ?, email = ?, phone = ?, yearOfStudy = ?, regNumber = ?, courseOfStudy = ?, profilePicture = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssssssi", $name, $email, $phone, $yearOfStudy, $regNumber, $courseOfStudy, $profilePicture, $member_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Member details updated successfully.";
        header("Location: view_members.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating member details: " . $stmt->error;
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
    <title>Edit Member</title>
    <link rel="stylesheet" href="style_edit.css"> <!-- Adjust the path to your CSS file -->
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit Member Details</h1>
        </div>
        <div class="content">
            <?php if (!empty($error_message)) : ?>
                <p class="error-message"><?php echo $error_message; ?></p>
                <a href="view_members.php" class="btn cancel-btn">Back to Members</a>
            <?php else : ?>
                <form method="POST" action="edit_member.php?id=<?php echo htmlspecialchars($member_id); ?>" enctype="multipart/form-data">
                    <div>
                        <h2>Member Details</h2>
                        <p>Please edit the details below.</p>
                        <hr>
                    </div>
                    <div class="form-group">
                        <label for="profilePicture">Profile Picture:</label> 
                        <input type="file" id="profilePicture" name="profilePicture">
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="yearOfStudy">Year of Study:</label>
                        <input type="number" id="yearOfStudy" name="yearOfStudy" value="<?php echo htmlspecialchars($yearOfStudy); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="regNumber">Registration Number:</label>
                        <input type="text" id="regNumber" name="regNumber" value="<?php echo htmlspecialchars($regNumber); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="courseOfStudy">Course of Study:</label>
                        <input type="text" id="courseOfStudy" name="courseOfStudy" value="<?php echo htmlspecialchars($courseOfStudy); ?>" required>
                    </div>
                    <button type="submit" class="btn">Update</button>
                    <a href="members.php" class="btn cancel-btn">Cancel</a>
                    <a href="create_password.php?id=<?php echo htmlspecialchars($member_id); ?>" class="btn">Create Password</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

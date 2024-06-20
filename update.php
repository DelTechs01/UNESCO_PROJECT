<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $yearOfStudy = $_POST["yearOfStudy"];
    $regNumber = $_POST["regNumber"];
    $courseOfStudy = $_POST["courseOfStudy"];

    $sql = "UPDATE members SET name=?, email=?, phone=?, dob=?, yearOfStudy=?, regNumber=?, courseOfStudy=? WHERE id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssi", $name, $email, $phone, $dob, $yearOfStudy, $regNumber, $courseOfStudy, $id);

        if ($stmt->execute()) {
            header("location: member_portal.php");
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>

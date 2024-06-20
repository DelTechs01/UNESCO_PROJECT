<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email address
        echo "Invalid email format";
        exit;
    }

    // Email details
    $to = 'kweyudelron37@gmail.com'; // Replace with your club's email address
    $subject = 'Contact Request from Website';
    $message_body = "Name: $name\n\nEmail: $email\n\nMessage:\n$message";

    // Headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain; charset=utf-8\r\n";

    // Send email
    if (mail($to, $subject, $message_body, $headers)) {
        // Email sent successfully
        echo "Your message has been sent.";
    } else {
        // Error sending email
        echo "Error: Unable to send email. Please try again later.";
    }
} else {
    // Redirect to the Help page if accessed directly
    header("Location: help.php");
    exit;
}
?>

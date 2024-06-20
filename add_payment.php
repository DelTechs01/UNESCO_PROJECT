<?php
require 'db_connection.php';

// Retrieve form data
$member_id = $_POST['member_id'];
$payment_date = $_POST['payment_date'];
$amount = $_POST['amount'];

// Check if member exists
$sql_check_member = "SELECT * FROM members WHERE id = ?";
$stmt_check_member = $conn->prepare($sql_check_member);
$stmt_check_member->bind_param("i", $member_id);
$stmt_check_member->execute();
$result_check_member = $stmt_check_member->get_result();

if ($result_check_member->num_rows > 0) {
    // Member exists, proceed to insert payment record
    $sql_insert_payment = "INSERT INTO payments (member_id, payment_date, amount) VALUES (?, ?, ?)";
    $stmt_insert_payment = $conn->prepare($sql_insert_payment);
    $stmt_insert_payment->bind_param("isd", $member_id, $payment_date, $amount);

    if ($stmt_insert_payment->execute()) {
        echo "Payment record inserted successfully.";
    } else {
        echo "Error inserting payment record: " . $stmt_insert_payment->error;
    }

    $stmt_insert_payment->close();
} else {
    echo "Error: Member with ID $member_id does not exist.";
}

$stmt_check_member->close();
$conn->close();
?>

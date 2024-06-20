<?php
require 'db_connection.php';

// Fetch recent payments
$sql = "SELECT members.name, payments.payment_id, payments.payment_date, payments.amount
FROM payments
INNER JOIN members ON payments.member_id = members.id
ORDER BY payments.payment_date DESC
LIMIT 6";

$result = $conn->query($sql);

$recent_payments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_payments[] = $row;
    }
}

// Fetch total contributions for each member
$sql = "SELECT m.name, SUM(p.amount) as total_contributions 
        FROM payments p 
        JOIN members m ON p.member_id = m.id 
        GROUP BY p.member_id";
$result = $conn->query($sql);

$total_contributions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_contributions[] = $row;
    }
}

// Fetch total amount in the account
$sql = "SELECT SUM(amount) as total_amount FROM payments";
$result = $conn->query($sql);

$total_amount = 0;
if ($row = $result->fetch_assoc()) {
    $total_amount = $row['total_amount'];
}

$response = [
    'recent_payments' => $recent_payments,
    'total_contributions' => $total_contributions,
    'total_amount' => $total_amount,
];

echo json_encode($response);

$conn->close();
?>

<?php
// Start session and include database connection
session_start();
include 'db_connection.php'; // Adjust the path as per your file structure

// Check if user is logged in, if not redirect to login page
//if (!isset($_SESSION['username'])) {
    //header("Location: login.php");
    //exit();
//}

// Fetch all payment records including member names
$sql = "SELECT members.name, payments.payment_id, payments.payment_date, payments.amount
        FROM payments
        INNER JOIN members ON payments.member_id = members.id
        ORDER BY payments.payment_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments</title>
    <link rel="stylesheet" href="view.css"> <!-- Adjust the path to your stylesheet -->
    <style>
        /* Add any additional inline styles if necessary */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background:linear-gradient(to right, #3f5efb, #fc466b);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payments Details</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Payment ID</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["payment_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["payment_date"]) . "</td>";
                        echo "<td>Ksh." . number_format($row["amount"], 2) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No payments found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>

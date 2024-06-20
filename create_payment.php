<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .title {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .title h2 {
            margin: 0;
            font-size: 24px;
            color: #0f64e4;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            margin-top: 10px;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="date"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            width: 100%;
            box-sizing: border-box;
        }

        form button {
            margin-top: 20px;
            padding: 10px;
            border: none;
            background-color: #0f64e4;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            outline: none;
        }

        form button:hover {
            background-color: #011535;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <h2>Add Payment</h2>
        </div>
        <form action="add_payment.php" method="POST">
            <label for="member_id">Member ID:</label>
            <input type="number" id="member_id" name="member_id" required><br>

            <label for="payment_date">Payment Date:</label>
            <input type="date" id="payment_date" name="payment_date" required><br>

            <label for="amount">Amount:</label>
            <input type="number" step="0.01" id="amount" name="amount" required><br>

            <button type="submit">Add Payment</button>
        </form>
    </div>
</body>
</html>

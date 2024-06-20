<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Dashboard</title>
    <link rel="stylesheet" href="pay.css">
</head>
<body>
    <div class="container">
        <div class="title">
            <h2>Recent Payments</h2>
            <a href="#" class="btn">View All</a>
        </div>
        <div class="content-2">
            <div class="recent-payments">
                <div class="title">
                    <h2>Recent Payments</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Payment ID</th>
                            <th>Payment Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="payments-table">
                        <!-- Payment rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="total-contributions">
            <h2>Total Contributions</h2>
            <ul id="contributions-list">
                <!-- Contribution items will be inserted here by JavaScript -->
            </ul>
        </div>
        <div class="total-amount">
            <h2>Total Amount in Account: <span id="total-amount">Ksh.0</span></h2>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

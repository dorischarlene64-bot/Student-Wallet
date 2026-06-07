<?php
session_start();
include 'db_connect.php';

// Check if the session actually has a user_id
if (!isset($_SESSION['user_id'])) {
    // If not, it sends you back to login (this is why it might not be "redirecting")
    header("Location: Login.html");
    exit();
}
$uid = $_SESSION['user_id'];

// 1. Fetch Student Balance and Name
$userQuery = $conn->query("SELECT student_name, balance FROM Users WHERE student_id = '$uid'");
$userData = $userQuery->fetch_assoc();

// 2. Fetch Last 5 Transactions
$transQuery = $conn->query("SELECT amount, timestamp FROM Transactions WHERE student_id = '$uid' ORDER BY timestamp DESC LIMIT 5");
?>

<!Doctype html>
<html>
<head>
    <title>Student Dashboard</title>

</head>
<body>
<div class="container">
    <fieldset>
        <legend><h2>Welcome, <?php echo $userData['student_name']; ?></h2></legend>
        
        <div class="balance-card" style="background-color: #007bff; color: white; padding: 20px; border-radius: 8px;">
            <p>Current Wallet Balance</p>
            <h1>PTS <?php echo number_format($userData['balance'], 2); ?></h1>
        </div>

        <h3>Recent Spending</h3>
        <table border="1" style="width:100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($transQuery->num_rows > 0) {
                    while($row = $transQuery->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['timestamp'] . "</td>
                                <td>-PTS" . number_format($row['amount'], 2) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No transactions yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <br/>
        <a href="logout.php" style="color: red; text-decoration: none; font-weight: bold;">Logout</a>
    </fieldset>
</div>
</body>
</html>
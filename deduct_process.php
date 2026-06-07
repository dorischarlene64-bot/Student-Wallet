<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['Student_ID'];
    $amount = $_POST['Amount'];

    // 1. Get current balance
    $checkUser = $conn->query("SELECT balance FROM Users WHERE student_id = '$uid'");
    
    if ($checkUser->num_rows > 0) {
        $row = $checkUser->fetch_assoc();
        $current_balance = $row['balance'];

        // 2. Check if enough funds
        if ($current_balance >= $amount) {
            $new_balance = $current_balance - $amount;

            // 3. Update the Student's Wallet
            $update_sql = "UPDATE Users SET balance = $new_balance WHERE student_id = '$uid'";
            
            // 4. Record the transaction for history
            $record_sql = "INSERT INTO Transactions (student_id, amount) VALUES ('$uid', '$amount')";

            if ($conn->query($update_sql) && $conn->query($record_sql)) {
                echo "Payment Successful! Remaining Balance: " . $new_balance;
                echo "<br><a href='Canteen.html'>Back to Canteen</a>";
            }
        } else {
            echo "Error: Insufficient funds. Current balance is only " . $current_balance;
        }
    } else {
        echo "Error: Student ID not found.";
    }
}
?>
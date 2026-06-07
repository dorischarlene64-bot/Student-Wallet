<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['Student_ID'];
    $amount = $_POST['Amount'];

    // DEBUG: This will tell us if the PHP actually received the data
    echo "Attempting to add $amount to Student: $uid <br>";

    $sql = "UPDATE Users SET balance = balance + $amount WHERE UPPER(student_id) = UPPER('$uid')";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "Success! Database updated.";
        } else {
            echo "Error: The ID $uid does not exist in the database.";
        }
    } else {
        echo "SQL Error: " . $conn->error;
    }
}
?>
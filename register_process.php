<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // These match the 'placeholder' names in your HTML
    $name = $_POST['Full_Name']; 
    $uid = $_POST['University_ID'];
    $pass = $_POST['Password'];

    $sql = "INSERT INTO Users (student_id, student_name, password, balance, role) 
            VALUES ('$uid', '$name', '$pass', 0.00, 'student')";

  if ($conn->query($sql) === TRUE) {
    echo "Registration Successful!";
    // This sends them to the Login page to enter their new credentials
    header("refresh:2; url=Login.html"); 

    } else {
        echo "Error: " . $conn->error;
    }
}
?>


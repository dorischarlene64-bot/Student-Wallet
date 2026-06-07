<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
// 1. Start session handling
session_start();
session_unset(); 
session_destroy(); 
session_start(); // Immediately start a FRESH session for the new user

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['Student_ID'];
    $pass = $_POST['Password'];

    // 2. Query the database
    $sql = "SELECT * FROM Users WHERE student_id = '$uid' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // 3. SAVE the new user's ID into the FRESH session
        $_SESSION['user_id'] = $user['student_id'];
        $_SESSION['role'] = $user['role'];

        // 4. Redirect based on role
        if ($user['role'] == 'admin') {
            header("Location: Admin.html");
            exit();
        } elseif ($user['role']=='student'){
            header("Location: Student.php");
            exit();
        }
         elseif ($user['role'] == 'canteen') {
            header("Location: Canteen.html");
            exit();
         }
         else{
            echo"Invalid credendials.";
         }
}
}
?>
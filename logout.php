<?php
session_start();
session_unset();
session_destroy();
header("Location: Login.html"); // Redirect back to the entering page
exit();
?>
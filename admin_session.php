<?php
session_start();

// Check if request is valid
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["action"] === "set_admin") {
    $_SESSION['code'] = 'admin_code';
    // $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_activity'] = time();
    echo "success"; // Return success message
} else {
    echo "error"; // Return error message if invalid request
}
?>

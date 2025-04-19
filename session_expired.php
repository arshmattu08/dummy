<?php
include "header.php";
session_start();
session_destroy(); // Destroy the session to force re-login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Expired</title>
</head>
<body>

<div class="container">
    <h2>Session Expired</h2>
    <p>Your session has expired due to inactivity. Please log in again to continue.</p>
    <a href="signin.php">Go to Login</a>
</div>
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white mt-5 py-5 px-sm-3 px-md-5">
        <?php
            include "footer.php";
        ?>
    </div>
</body>
</html>

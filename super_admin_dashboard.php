<?php
session_start();
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "header.php";

?>
 <?php 
// to make sure outsiders can't access through URL
if ($_SESSION['role'] !== 'super') {
    header("Location: access_denied.php"); // Redirect to homepage if not admin
    exit();
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Typewriter Effect */
        .typewriter {
            font-family: 'Courier New', Courier, monospace;
            overflow: hidden; /* Ensures the text doesn't overflow */
            border-right: .15em solid black; /* Adds the cursor */
            white-space: nowrap; /* Prevents text from wrapping */
            display: inline-block;
            max-width: 100%;
            width: 0; /* Starts with no width */
            animation: typing 1.2s steps(35) 0.8s forwards, blink-caret .75s step-end infinite;
        }

        @keyframes typing {
            0% {
                width: 0;
            }
            100% {
                width: 23ch;
            }
        }

        @keyframes blink-caret {
            50% {
                border-color: transparent;
            }
        }
        .spinny-gear {
            animation: spin 4s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-lg-5" >
            <!-- This is for doctors-->
            <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    <a href="h_admin_doc.php" class="nav-item nav-link">Doctors</a>
                    <a href="su_view_hadmin.php" class="nav-item nav-link">Hosp. Admins</a>
                 </div> 
            </div>
        </nav>
    </div>

    <div class="container text-center mt-5">
    <h1>Welcome! System Admin.</h1> <br> <br> 
        <h3><span class="typewriter">Glad to have you back.</span></h3>
</div>
<br><br><br><br><br><br><br><br>
  
    
</body>
</html>

<div style="text-align: center; margin-top: 30px;">
    <i class="fas fa-cog spinny-gear" style="font-size: 65px; color: #007bff;"></i>
</div>
<?php ob_end_flush(); ?>
<!-- Footer Start -->
<!-- <div class="container-fluid bg-dark text-white py-5 px-sm-3 px-md-5">
</div> -->







